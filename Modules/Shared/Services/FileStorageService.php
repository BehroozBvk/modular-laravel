<?php

declare(strict_types=1);

namespace Modules\Shared\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Shared service for file storage operations
 */
final class FileStorageService
{
    /**
     * Constructor with optional disk configuration
     */
    public function __construct(
        private readonly string $disk = 'public'
    ) {}

    /**
     * Store a file and return the path
     *
     * @param UploadedFile $file The file to store
     * @param string $path The path within the storage disk
     * @param string|null $filename Custom filename (optional)
     * @return string The stored file path
     */
    public function store(UploadedFile $file, string $path, ?string $filename = null): string
    {
        if ($filename) {
            $extension = $file->getClientOriginalExtension();
            $fullPath = "{$path}/{$filename}.{$extension}";

            // Stream to file location to avoid memory issues with large files
            $stream = fopen($file->getRealPath(), 'r');
            Storage::disk($this->disk)->put($fullPath, $stream);

            if (is_resource($stream)) {
                fclose($stream);
            }

            return $fullPath;
        }

        return $file->store($path, $this->disk);
    }

    /**
     * Delete a file if it exists
     *
     * @param string|null $path The file path to delete
     * @return bool Whether the file was deleted
     */
    public function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * Check if a file exists
     *
     * @param string|null $path The file path to check
     * @return bool Whether the file exists
     */
    public function exists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        return Storage::disk($this->disk)->exists($path);
    }

    /**
     * Get the full URL for a file
     *
     * @param string|null $path The file path
     * @return string|null The full URL or null if path is empty
     */
    public function url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return url("storage/{$path}");
    }
}

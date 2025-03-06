<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Http\UploadedFile;
use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Models\AboutIntro;
use Modules\Shared\Services\FileStorageService;

/**
 * Service for managing about intro
 */
final class AboutIntroService
{
    /**
     * AboutIntroService constructor
     */
    public function __construct(
        private readonly AboutIntroRepositoryInterface $introRepository,
        private readonly FileStorageService $fileStorage
    ) {}

    /**
     * Get the active about intro
     * 
     * @return AboutIntro|null
     */
    public function getActiveIntro(): ?AboutIntro
    {
        return $this->introRepository->getActive();
    }

    /**
     * Create a new about intro
     * 
     * @param array<string, mixed> $data
     * @return AboutIntro
     */
    public function createIntro(array $data): AboutIntro
    {
        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $data['image_path'] = $this->fileStorage->store(
                $data['image_path'],
                'about/intro'
            );
        }

        if (isset($data['background_path']) && $data['background_path'] instanceof UploadedFile) {
            $data['background_path'] = $this->fileStorage->store(
                $data['background_path'],
                'about/backgrounds'
            );
        }

        return $this->introRepository->create($data);
    }

    /**
     * Update an existing about intro
     * 
     * @param int $id
     * @param array<string, mixed> $data
     * @return AboutIntro|null
     */
    public function updateIntro(int $id, array $data): ?AboutIntro
    {
        $intro = $this->introRepository->findAboutIntroOrFail($id);

        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $this->fileStorage->delete($intro->getRawOriginal('image_path'));

            $data['image_path'] = $this->fileStorage->store(
                $data['image_path'],
                'about/intro'
            );
        }

        if (isset($data['background_path']) && $data['background_path'] instanceof UploadedFile) {
            $this->fileStorage->delete($intro->getRawOriginal('background_path'));

            $data['background_path'] = $this->fileStorage->store(
                $data['background_path'],
                'about/backgrounds'
            );
        }

        return $this->introRepository->update($id, $data);
    }

    /**
     * Delete an about intro
     * 
     * @param int $id
     * @return bool
     */
    public function deleteIntro(int $id): bool
    {
        $intro = $this->introRepository->findAboutIntroOrFail($id);

        $this->fileStorage->delete($intro->getRawOriginal('image_path'));
        $this->fileStorage->delete($intro->getRawOriginal('background_path'));

        return $this->introRepository->delete($id);
    }
}

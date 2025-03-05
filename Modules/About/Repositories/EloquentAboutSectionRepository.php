<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Models\AboutSection;

/**
 * Eloquent implementation of the AboutSection repository
 */
final class EloquentAboutSectionRepository implements AboutSectionRepositoryInterface
{
    /**
     * Get all about sections
     */
    public function getAll(): Collection
    {
        return AboutSection::orderBy('order')->get();
    }

    /**
     * Find an about section by ID
     */
    public function findById(int $id): ?AboutSection
    {
        return AboutSection::with('translations')->find($id);
    }

    /**
     * Find an about section by ID or fail
     */
    public function findAboutSectionOrFail(int $id): AboutSection
    {
        return AboutSection::findOrFail($id);
    }

    /**
     * Create a new about section
     */
    public function create(array $data): AboutSection
    {
        // Get the highest order value and add 1
        $maxOrder = AboutSection::max('order') ?? 0;

        $section = AboutSection::create([
            'icon_path' => $data['icon_path'],
            'order' => $data['order'] ?? $maxOrder + 1,
        ]);

        // Create translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $section->translations()->create([
                    'locale' => $translation['locale'],
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }
        }

        return $section->load('translations');
    }

    /**
     * Update an existing about section
     */
    public function update(int $id, array $data): ?AboutSection
    {
        $section = $this->findAboutSectionOrFail($id);

        $section->update([
            'icon_path' => $data['icon_path'] ?? $section->icon_path,
            'order' => $data['order'] ?? $section->order,
        ]);

        // Update translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $section->translations()->updateOrCreate(
                    ['locale' => $translation['locale']],
                    [
                        'title' => $translation['title'],
                        'description' => $translation['description'],
                    ]
                );
            }
        }

        return $section->load('translations');
    }

    /**
     * Delete an about section
     */
    public function delete(int $id): bool
    {
        $section = $this->findAboutSectionOrFail($id);

        return (bool) $section->delete();
    }

    /**
     * Reorder about sections
     */
    public function reorder(array $orderedIds): bool
    {
        try {
            DB::beginTransaction();

            foreach ($orderedIds as $index => $id) {
                AboutSection::where('id', $id)->update(['order' => $index + 1]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

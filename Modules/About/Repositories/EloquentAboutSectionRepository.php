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
     * Get all about sections ordered by order
     */
    public function getAll(): Collection
    {
        return AboutSection::with('translations')
            ->orderBy('order')
            ->get();
    }

    /**
     * Find an about section by ID
     */
    public function findById(int $id): ?AboutSection
    {
        return AboutSection::with('translations')->find($id);
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
        $section = AboutSection::find($id);

        if (!$section) {
            return null;
        }

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
        $section = AboutSection::find($id);

        if (!$section) {
            return false;
        }

        // Translations will be deleted by the cascade constraint
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

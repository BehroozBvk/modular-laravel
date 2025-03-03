<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Models\AboutIntro;

/**
 * Eloquent implementation of the AboutIntro repository
 */
final class EloquentAboutIntroRepository implements AboutIntroRepositoryInterface
{
    /**
     * Get the active about intro
     */
    public function getActive(): ?AboutIntro
    {
        return AboutIntro::with('translations')->first();
    }

    /**
     * Find an about intro by ID
     */
    public function findById(int $id): ?AboutIntro
    {
        return AboutIntro::with('translations')->find($id);
    }

    /**
     * Create a new about intro
     */
    public function create(array $data): AboutIntro
    {
        $intro = AboutIntro::create([
            'image_path' => $data['image_path'],
            'background_path' => $data['background_path'],
        ]);

        // Create translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $intro->translations()->create([
                    'locale' => $translation['locale'],
                    'title' => $translation['title'],
                    'description' => $translation['description'],
                ]);
            }
        }

        return $intro->load('translations');
    }

    /**
     * Update an existing about intro
     */
    public function update(int $id, array $data): ?AboutIntro
    {
        $intro = AboutIntro::find($id);

        if (!$intro) {
            return null;
        }

        $intro->update([
            'image_path' => $data['image_path'] ?? $intro->image_path,
            'background_path' => $data['background_path'] ?? $intro->background_path,
        ]);

        // Update translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $intro->translations()->updateOrCreate(
                    ['locale' => $translation['locale']],
                    [
                        'title' => $translation['title'],
                        'description' => $translation['description'],
                    ]
                );
            }
        }

        return $intro->load('translations');
    }

    /**
     * Delete an about intro
     */
    public function delete(int $id): bool
    {
        $intro = AboutIntro::find($id);

        if (!$intro) {
            return false;
        }

        // Translations will be deleted by the cascade constraint
        return (bool) $intro->delete();
    }
}

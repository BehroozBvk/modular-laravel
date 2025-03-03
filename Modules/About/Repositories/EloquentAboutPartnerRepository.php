<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Models\AboutPartner;

/**
 * Eloquent implementation of the AboutPartner repository
 */
final class EloquentAboutPartnerRepository implements AboutPartnerRepositoryInterface
{
    /**
     * Get all partners ordered by order
     */
    public function getAll(): Collection
    {
        return AboutPartner::with('translations')
            ->orderBy('order')
            ->get();
    }

    /**
     * Find a partner by ID
     */
    public function findById(int $id): ?AboutPartner
    {
        return AboutPartner::with('translations')->find($id);
    }

    /**
     * Create a new partner
     */
    public function create(array $data): AboutPartner
    {
        // Get the highest order value and add 1
        $maxOrder = AboutPartner::max('order') ?? 0;

        $partner = AboutPartner::create([
            'icon_path' => $data['icon_path'],
            'link' => $data['link'],
            'order' => $data['order'] ?? $maxOrder + 1,
        ]);

        // Create translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $partner->translations()->create([
                    'locale' => $translation['locale'],
                    'name' => $translation['name'],
                ]);
            }
        }

        return $partner->load('translations');
    }

    /**
     * Update an existing partner
     */
    public function update(int $id, array $data): ?AboutPartner
    {
        $partner = AboutPartner::find($id);

        if (!$partner) {
            return null;
        }

        $partner->update([
            'icon_path' => $data['icon_path'] ?? $partner->icon_path,
            'link' => $data['link'] ?? $partner->link,
            'order' => $data['order'] ?? $partner->order,
        ]);

        // Update translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $partner->translations()->updateOrCreate(
                    ['locale' => $translation['locale']],
                    [
                        'name' => $translation['name'],
                    ]
                );
            }
        }

        return $partner->load('translations');
    }

    /**
     * Delete a partner
     */
    public function delete(int $id): bool
    {
        $partner = AboutPartner::find($id);

        if (!$partner) {
            return false;
        }

        // Translations will be deleted by the cascade constraint
        return (bool) $partner->delete();
    }

    /**
     * Reorder partners
     */
    public function reorder(array $orderedIds): bool
    {
        try {
            DB::beginTransaction();

            foreach ($orderedIds as $index => $id) {
                AboutPartner::where('id', $id)->update(['order' => $index + 1]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

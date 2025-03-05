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
     * Get all partners
     */
    public function getAll(): Collection
    {
        return AboutPartner::orderBy('order')->get();
    }

    /**
     * Find a partner by ID
     */
    public function findById(int $id): ?AboutPartner
    {
        return AboutPartner::with('translations')->find($id);
    }

    /**
     * Find a partner by ID or fail
     */
    public function findAboutPartnerOrFail(int $id): AboutPartner
    {
        return AboutPartner::findOrFail($id);
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
        $partner = $this->findAboutPartnerOrFail($id);

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
        $partner = $this->findAboutPartnerOrFail($id);

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

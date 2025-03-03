<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Models\AboutTeamMember;

/**
 * Eloquent implementation of the AboutTeamMember repository
 */
final class EloquentAboutTeamMemberRepository implements AboutTeamMemberRepositoryInterface
{
    /**
     * Get all team members ordered by order
     */
    public function getAll(): Collection
    {
        return AboutTeamMember::with('translations')
            ->orderBy('order')
            ->get();
    }

    /**
     * Find a team member by ID
     */
    public function findById(int $id): ?AboutTeamMember
    {
        return AboutTeamMember::with('translations')->find($id);
    }

    /**
     * Create a new team member
     */
    public function create(array $data): AboutTeamMember
    {
        // Get the highest order value and add 1
        $maxOrder = AboutTeamMember::max('order') ?? 0;

        $member = AboutTeamMember::create([
            'image_path' => $data['image_path'],
            'order' => $data['order'] ?? $maxOrder + 1,
        ]);

        // Create translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $member->translations()->create([
                    'locale' => $translation['locale'],
                    'name' => $translation['name'],
                    'position' => $translation['position'],
                ]);
            }
        }

        return $member->load('translations');
    }

    /**
     * Update an existing team member
     */
    public function update(int $id, array $data): ?AboutTeamMember
    {
        $member = AboutTeamMember::find($id);

        if (!$member) {
            return null;
        }

        $member->update([
            'image_path' => $data['image_path'] ?? $member->image_path,
            'order' => $data['order'] ?? $member->order,
        ]);

        // Update translations
        if (isset($data['translations']) && is_array($data['translations'])) {
            foreach ($data['translations'] as $translation) {
                $member->translations()->updateOrCreate(
                    ['locale' => $translation['locale']],
                    [
                        'name' => $translation['name'],
                        'position' => $translation['position'],
                    ]
                );
            }
        }

        return $member->load('translations');
    }

    /**
     * Delete a team member
     */
    public function delete(int $id): bool
    {
        $member = AboutTeamMember::find($id);

        if (!$member) {
            return false;
        }

        // Translations will be deleted by the cascade constraint
        return (bool) $member->delete();
    }

    /**
     * Reorder team members
     */
    public function reorder(array $orderedIds): bool
    {
        try {
            DB::beginTransaction();

            foreach ($orderedIds as $index => $id) {
                AboutTeamMember::where('id', $id)->update(['order' => $index + 1]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

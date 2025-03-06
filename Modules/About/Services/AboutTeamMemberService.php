<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Models\AboutTeamMember;
use Modules\Shared\Services\FileStorageService;

/**
 * Service for managing about team members
 */
final class AboutTeamMemberService
{
    /**
     * AboutTeamMemberService constructor
     */
    public function __construct(
        private readonly AboutTeamMemberRepositoryInterface $teamMemberRepository,
        private readonly FileStorageService $fileStorage
    ) {}

    /**
     * Get all team members
     * 
     * @return Collection<int, AboutTeamMember>
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMemberRepository->getAll();
    }

    /**
     * Create a new team member
     * 
     * @param array<string, mixed> $data
     * @return AboutTeamMember
     */
    public function createTeamMember(array $data): AboutTeamMember
    {
        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $data['image_path'] = $this->fileStorage->store(
                file: $data['image_path'],
                path: 'about/team-members/images'
            );
        }

        return $this->teamMemberRepository->create($data);
    }

    /**
     * Update an existing team member
     * 
     * @param int $id
     * @param array<string, mixed> $data
     * @return AboutTeamMember|null
     */
    public function updateTeamMember(int $id, array $data): ?AboutTeamMember
    {
        $teamMember = $this->teamMemberRepository->findAboutTeamMemberOrFail($id);

        if (isset($data['image_path']) && $data['image_path'] instanceof UploadedFile) {
            $this->fileStorage->delete(path: $teamMember->getRawOriginal('image_path'));

            $data['image_path'] = $this->fileStorage->store(
                file: $data['image_path'],
                path: 'about/team-members/images'
            );
        }

        return $this->teamMemberRepository->update($id, $data);
    }

    /**
     * Delete a team member
     * 
     * @param int $id
     * @return bool
     */
    public function deleteTeamMember(int $id): bool
    {
        $teamMember = $this->teamMemberRepository->findAboutTeamMemberOrFail($id);

        $this->fileStorage->delete($teamMember->getRawOriginal('image_path'));

        return $this->teamMemberRepository->delete($id);
    }

    /**
     * Reorder team members
     * 
     * @param array<int, int> $orderedIds
     * @return bool
     */
    public function reorderTeamMembers(array $orderedIds): bool
    {
        return $this->teamMemberRepository->reorder($orderedIds);
    }
}

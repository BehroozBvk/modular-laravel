<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Illuminate\Database\Eloquent\Collection;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;
use Modules\About\Models\AboutTeamMember;
use Modules\About\Models\AboutTeamSetting;

/**
 * Service for about team operations
 */
final class AboutTeamService
{
    public function __construct(
        private readonly AboutTeamSettingRepositoryInterface $teamSettingRepository,
        private readonly AboutTeamMemberRepositoryInterface $teamMemberRepository
    ) {}

    /**
     * Get team settings
     */
    public function getTeamSettings(): ?AboutTeamSetting
    {
        return $this->teamSettingRepository->getSettings();
    }

    /**
     * Update team settings
     */
    public function updateTeamSettings(array $data): ?AboutTeamSetting
    {
        return $this->teamSettingRepository->updateSettings($data);
    }

    /**
     * Get all team members
     */
    public function getTeamMembers(): Collection
    {
        return $this->teamMemberRepository->getAll();
    }

    /**
     * Create a new team member
     */
    public function createTeamMember(array $data): AboutTeamMember
    {
        return $this->teamMemberRepository->create($data);
    }

    /**
     * Update an existing team member
     */
    public function updateTeamMember(int $id, array $data): ?AboutTeamMember
    {
        return $this->teamMemberRepository->update($id, $data);
    }

    /**
     * Delete a team member
     */
    public function deleteTeamMember(int $id): bool
    {
        return $this->teamMemberRepository->delete($id);
    }

    /**
     * Reorder team members
     */
    public function reorderTeamMembers(array $orderedIds): bool
    {
        return $this->teamMemberRepository->reorder($orderedIds);
    }

    /**
     * Get complete team data
     */
    public function getTeamData(): array
    {
        $teamSettings = $this->getTeamSettings();

        return [
            'visible' => $teamSettings ? $teamSettings->visible : true,
            'members' => $teamSettings && $teamSettings->visible ? $this->getTeamMembers() : [],
        ];
    }
}

<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Modules\About\Models\AboutTeamSetting;

/**
 * Interface for About Team Settings repository operations
 */
interface AboutTeamSettingRepositoryInterface
{
    /**
     * Get the team settings
     */
    public function getSettings(): ?AboutTeamSetting;

    /**
     * Update team settings
     */
    public function updateSettings(array $data): ?AboutTeamSetting;

    /**
     * Find a team setting by ID or fail
     */
    public function findAboutTeamSettingOrFail(int $id): AboutTeamSetting;
}

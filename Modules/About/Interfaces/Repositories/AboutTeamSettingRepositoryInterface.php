<?php

declare(strict_types=1);

namespace Modules\About\Interfaces\Repositories;

use Modules\About\Models\AboutTeamSetting;

/**
 * Interface for AboutTeamSetting repository operations
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
}

<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;
use Modules\About\Models\AboutTeamSetting;

/**
 * Eloquent implementation of AboutTeamSettingRepositoryInterface
 */
final class EloquentAboutTeamSettingRepository implements AboutTeamSettingRepositoryInterface
{
    /**
     * Get the team settings
     */
    public function getSettings(): ?AboutTeamSetting
    {
        return AboutTeamSetting::first();
    }

    /**
     * Find a team setting by ID or fail
     */
    public function findAboutTeamSettingOrFail(int $id): AboutTeamSetting
    {
        return AboutTeamSetting::findOrFail($id);
    }

    /**
     * Update team settings
     */
    public function updateSettings(array $data): ?AboutTeamSetting
    {
        $settings = $this->getSettings();

        if (!$settings) {
            return null;
        }

        $settings->update([
            'visible' => $data['visible'] ?? $settings->visible,
        ]);

        return $settings->refresh();
    }
}

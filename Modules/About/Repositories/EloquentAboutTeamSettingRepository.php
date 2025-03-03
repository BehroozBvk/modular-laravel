<?php

declare(strict_types=1);

namespace Modules\About\Repositories;

use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;
use Modules\About\Models\AboutTeamSetting;

/**
 * Eloquent implementation of the AboutTeamSetting repository
 */
final class EloquentAboutTeamSettingRepository implements AboutTeamSettingRepositoryInterface
{
    /**
     * Get the team settings
     */
    public function getSettings(): ?AboutTeamSetting
    {
        return AboutTeamSetting::first() ?? AboutTeamSetting::create(['visible' => true]);
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

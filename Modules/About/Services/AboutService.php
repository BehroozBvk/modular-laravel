<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;

/**
 * Service for About page operations
 */
final class AboutService
{
    /**
     * AboutService constructor
     */
    public function __construct(
        private readonly AboutIntroRepositoryInterface $introRepository,
        private readonly AboutSectionRepositoryInterface $sectionRepository,
        private readonly AboutTeamSettingRepositoryInterface $teamSettingRepository,
        private readonly AboutTeamMemberRepositoryInterface $teamMemberRepository,
        private readonly AboutPartnerRepositoryInterface $partnerRepository
    ) {}

    /**
     * Get all about page data
     * 
     * @return array<string, mixed>
     */
    public function getAboutPageData(): array
    {
        $intro = $this->introRepository->getActive();
        $sections = $this->sectionRepository->getAll();
        $teamSettings = $this->teamSettingRepository->getSettings();
        $teamMembers = $this->teamMemberRepository->getAll();
        $partners = $this->partnerRepository->getAll();

        return [
            'intro' => $intro,
            'sections' => $sections,
            'team_settings' => $teamSettings ?? null,
            'team_members' => $teamMembers,
            'partners' => $partners,
        ];
    }
}

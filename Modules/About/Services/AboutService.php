<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutPartnerRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutSectionRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamMemberRepositoryInterface;
use Modules\About\Interfaces\Repositories\AboutTeamSettingRepositoryInterface;

final class AboutService
{
    public function __construct(
        private readonly AboutIntroRepositoryInterface $introRepository,
        private readonly AboutSectionRepositoryInterface $sectionRepository,
        private readonly AboutTeamSettingRepositoryInterface $teamSettingRepository,
        private readonly AboutTeamMemberRepositoryInterface $teamMemberRepository,
        private readonly AboutPartnerRepositoryInterface $partnerRepository
    ) {}

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
            'team' => [
                'visible' => $teamSettings ? $teamSettings->visible : true,
                'members' => $teamSettings && $teamSettings->visible ? $teamMembers : [],
            ],
            'partners' => $partners,
        ];
    }
}

<?php

declare(strict_types=1);

namespace Modules\About\Services;

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
        return [
            'intro' => $this->introRepository->getAboutIntro(),
            'sections' => $this->sectionRepository->getAboutSections(),
            'team' => $this->teamRepository->getAboutTeam(),
            'partners' => $this->partnerRepository->getAboutPartners(),
        ];
    }
}

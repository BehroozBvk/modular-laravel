<?php

declare(strict_types=1);

namespace Modules\About\Services;

use Modules\About\Interfaces\Repositories\AboutIntroRepositoryInterface;
use Modules\About\Models\AboutIntro;

/**
 * Service for about intro operations
 */
final class AboutIntroService
{
    public function __construct(
        private readonly AboutIntroRepositoryInterface $introRepository
    ) {}

    /**
     * Get the about intro
     */
    public function getIntro(): ?AboutIntro
    {
        return $this->introRepository->getActive();
    }

    /**
     * Create or update intro
     */
    public function saveIntro(array $data): ?AboutIntro
    {
        $intro = $this->getIntro();

        if ($intro) {
            return $this->introRepository->update($intro->id, $data);
        }

        return $this->introRepository->create($data);
    }
}

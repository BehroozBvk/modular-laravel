<?php

declare(strict_types=1);

namespace Modules\Core\DataTransferObjects;

class PaginationDto
{
    /**
     * @param int|null $page Current page number
     * @param int|null $perPage Items per page
     */
    public function __construct(
        public readonly ?int $page = 1,
        public readonly ?int $perPage = 15
    ) {}
}

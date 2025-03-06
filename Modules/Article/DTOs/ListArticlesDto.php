<?php

declare(strict_types=1);

namespace Modules\Article\DTOs;


/**
 * DTO for listing articles with pagination
 */
class ListArticlesDto
{
    /**
     * @param int $page The current page number
     * @param int $perPage Number of items per page
     */
    public function __construct(
        public readonly int $page = 1,
        public readonly int $perPage = 10,
    ) {}
}

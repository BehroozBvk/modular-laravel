<?php

declare(strict_types=1);

namespace Modules\Student\DataTransferObjects;

use Modules\Core\DataTransferObjects\PaginationDto;

final class ListStudentsDto extends PaginationDto
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?string $sort = null,
        public readonly ?string $direction = 'asc',
        public readonly ?int $student_parent_id = null,
        public readonly ?bool $active = null,
        ?int $page = null,
        ?int $perPage = null
    ) {
        parent::__construct($page, $perPage);
    }

    /**
     * Create a DTO from request data
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            search: $data['search'] ?? null,
            sort: $data['sort'] ?? null,
            direction: $data['direction'] ?? 'asc',
            student_parent_id: isset($data['student_parent_id']) ? (int) $data['student_parent_id'] : null,
            active: isset($data['active']) ? (bool) $data['active'] : null,
            page: isset($data['page']) ? (int) $data['page'] : null,
            perPage: isset($data['per_page']) ? (int) $data['per_page'] : null
        );
    }
}

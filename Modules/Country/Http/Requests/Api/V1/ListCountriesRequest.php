<?php

declare(strict_types=1);

namespace Modules\Country\Http\Requests\Api\V1;

use Illuminate\Validation\Rule;
use Modules\Country\DataTransferObjects\ListCountriesDto;
use Modules\Core\Http\Requests\Api\V1\BaseApiV1FormRequest;

/**
 * Request for listing countries with pagination and sorting
 */
final class ListCountriesRequest extends BaseApiV1FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            'sort_by' => ['sometimes', 'string', Rule::in(['created_at', 'name'])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    /**
     * Define body parameters for Scribe documentation
     *
     * @return array<string, array<string, mixed>>
     */
    public function bodyParameters(): array
    {
        return [
            'per_page' => [
                'description' => 'Number of items per page (1-100)',
                'example' => 15,
            ],
            'sort_by' => [
                'description' => 'Column to sort by',
                'example' => 'name',
            ],
            'sort_direction' => [
                'description' => 'Direction of sorting (asc or desc)',
                'example' => 'asc',
            ],
        ];
    }

    public function toDto(): ListCountriesDto
    {
        return ListCountriesDto::fromArray($this->validated());
    }

    public function perPage(): int
    {
        return (int) $this->input('per_page', 15);
    }

    public function sortBy(): string
    {
        return $this->input('sort_by', 'created_at');
    }

    public function sortDirection(): string
    {
        return strtolower($this->input('sort_direction', 'desc'));
    }
}

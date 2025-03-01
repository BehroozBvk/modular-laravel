<?php

declare(strict_types=1);

namespace Modules\Country\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Country\DataTransferObjects\ListCountriesDto;

final class ListCountriesRequest extends FormRequest
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

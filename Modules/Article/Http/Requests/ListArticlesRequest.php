<?php

declare(strict_types=1);

namespace Modules\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Article\DTOs\ListArticlesDto;

/**
 * Request validation for listing articles
 */
class ListArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     * 
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'page' => ['sometimes', 'integer', 'min:1'],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Convert the request to a DTO
     */
    public function toDto(): ListArticlesDto
    {
        return new ListArticlesDto(
            page: (int) $this->input('page', 1),
            perPage: (int) $this->input('per_page', 10),
        );
    }
}

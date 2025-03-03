<?php

declare(strict_types=1);

namespace Modules\Student\Http\Requests\Api\V1\Student;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Student\DataTransferObjects\ListStudentsDto;

class ListStudentsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:id,first_name,last_name,email,created_at,updated_at'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'student_parent_id' => ['nullable', 'integer', 'exists:student_parents,id'],
            'active' => ['nullable', 'boolean'],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    /**
     * Convert the request to a DTO
     */
    public function toDto(): ListStudentsDto
    {
        return ListStudentsDto::fromRequest([
            'search' => $this->input('search'),
            'sort' => $this->input('sort'),
            'direction' => $this->input('direction', 'asc'),
            'student_parent_id' => $this->input('student_parent_id'),
            'active' => $this->has('active') ? (bool) $this->input('active') : null,
            'page' => $this->input('page', 1),
            'per_page' => $this->input('per_page', 15),
        ]);
    }
}

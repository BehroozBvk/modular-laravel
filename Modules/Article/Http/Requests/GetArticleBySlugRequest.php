<?php

declare(strict_types=1);

namespace Modules\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request validation for retrieving an article by slug
 */
class GetArticleBySlugRequest extends FormRequest
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
            'slug' => ['required', 'string'],
        ];
    }

    /**
     * Get the validated slug from the request
     */
    public function getSlug(): string
    {
        return $this->route('slug');
    }
}

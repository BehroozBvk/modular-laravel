<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Base form request class that all module form requests should extend.
 *
 * @template TValidated of array
 *
 * @extends FormRequest<TValidated>
 */
abstract class BaseFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Always returns true as authorization should be handled at the controller/policy level.
     */
    final public function authorize(): bool
    {
        return true;
    }
}

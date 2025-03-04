<?php

declare(strict_types=1);

namespace Modules\Core\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\Core\Constants\HttpStatusConstants;
use Modules\Core\Constants\Messages\CoreMessageConstants;
use Modules\Core\Helpers\ApiResponse;
use Modules\Core\Http\Requests\BaseFormRequest;
use Override;

/**
 * Base API Form Request class that handles validation failures for API requests
 *
 * @template TValidated of array
 *
 * @extends BaseFormRequest<TValidated>
 */
abstract class BaseApiFormRequest extends BaseFormRequest
{
    /**
     * Handle failed validation by throwing an HTTP response exception
     * with formatted error response
     *
     * @param  Validator  $validator  The validator instance containing validation errors
     *
     * @throws HttpResponseException
     */
    #[Override]
    protected function failedValidation(Validator $validator): void
    {
        $jsonResponse = ApiResponse::error(
            message: CoreMessageConstants::get(CoreMessageConstants::VALIDATION_FAILED),
            statusCode: HttpStatusConstants::HTTP_422_UNPROCESSABLE_ENTITY,
            data: $validator->errors(),
        );

        throw new HttpResponseException($jsonResponse);
    }
}

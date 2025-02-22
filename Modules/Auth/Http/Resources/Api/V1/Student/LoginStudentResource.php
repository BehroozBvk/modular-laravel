<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\Student;

use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * @property-read PersonalAccessTokenResult $resource
 */
final class LoginStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'access_token' => $this->resource->accessToken,
            'type' => 'Bearer',
            'expires_at' => $this->resource->token->expires_at,
        ];
    }
}

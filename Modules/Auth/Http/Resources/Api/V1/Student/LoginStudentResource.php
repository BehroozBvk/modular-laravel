<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * @extends JsonResource<PersonalAccessTokenResult>
 */
final class LoginStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var PersonalAccessTokenResult $this */
        return [
            'token_type' => 'Bearer',
            'expires_in' => abs($this->token->expires_at->diffInSeconds(now())),
            'expires_at' => $this->token->expires_at->format('Y-m-d H:i:s'),
            'access_token' => $this->accessToken,
        ];
    }
}

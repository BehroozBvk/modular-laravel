<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;

final class LoginAdminResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var PersonalAccessTokenResult $this */
        return [
            'token_type' => 'Bearer',
            'expires_in' => $this->token->expires_at->diffInSeconds(now()),
            'access_token' => $this->accessToken,
        ];
    }
}

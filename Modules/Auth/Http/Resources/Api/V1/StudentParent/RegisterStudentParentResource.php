<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\StudentParent;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Models\User;

final class RegisterStudentParentResource extends JsonResource
{
    public function __construct(User $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        /** @var User $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'avatar' => $this->avatar,
            'country_id' => $this->country_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

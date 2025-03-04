<?php

declare(strict_types=1);

namespace Modules\StudentParent\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Country\Http\Resources\Api\V1\CountryResource;
use Modules\Student\Http\Resources\Api\V1\StudentResource;
use Modules\StudentParent\Models\StudentParent;
use Modules\User\Http\Resources\Api\V1\UserResource;

/**
 * @property-read StudentParent $resource
 */
final class StudentParentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'full_name' => $this->resource->full_name,
            'phone_number' => $this->resource->phone_number,
            'address' => $this->resource->address,
            'city' => $this->resource->city,
            'state' => $this->resource->state,
            'zip' => $this->resource->zip,
            'country_id' => $this->resource->country_id,
            'user_id' => $this->resource->user_id,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,

            // Relations
            'user' => $this->whenLoaded('user', fn() => new UserResource($this->resource->user)),
            'country' => $this->whenLoaded('country', fn() => new CountryResource($this->resource->country)),
            'students' => $this->whenLoaded('students', fn() => StudentResource::collection($this->resource->students)),
        ];
    }
}

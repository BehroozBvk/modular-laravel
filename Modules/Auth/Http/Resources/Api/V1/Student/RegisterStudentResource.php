<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\Student;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\Models\User;
use Carbon\CarbonInterface;
use OpenApi\Annotations as OA;

/**
 * @property-read User $resource
 * 
 * @OA\Schema(
 *     schema="RegisterStudentResource",
 *     required={"id", "name", "email", "type", "created_at"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone_number", type="string", nullable=true, example="+1234567890"),
 *     @OA\Property(property="first_name", type="string", nullable=true, example="John"),
 *     @OA\Property(property="last_name", type="string", nullable=true, example="Doe"),
 *     @OA\Property(property="avatar", type="string", nullable=true, example="https://example.com/avatar.jpg"),
 *     @OA\Property(property="country_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="type", type="string", example="student"),
 *     @OA\Property(property="created_at", type="string", format="date-time")
 * )
 */
final class RegisterStudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array{
     *     id: int,
     *     name: string,
     *     email: string,
     *     phone_number: string|null,
     *     first_name: string|null,
     *     last_name: string|null,
     *     avatar: string|null,
     *     country_id: int|null,
     *     type: string,
     *     created_at: CarbonInterface
     * }
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'phone_number' => $this->resource->phone_number,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'avatar' => $this->resource->avatar,
            'country_id' => $this->resource->country_id,
            'type' => $this->resource->type->value,
            'created_at' => $this->resource->created_at,
        ];
    }
}

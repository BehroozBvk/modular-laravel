<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Resources\Api\V1\Student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Student\Models\Student;
use Modules\User\Http\Resources\Api\V1\UserResource;
use Modules\Auth\Http\Resources\Api\V1\StudentParent\RegisterStudentParentResource;
use OpenApi\Annotations as OA;

/**
 * @extends JsonResource<Student>
 *
 * @OA\Schema(
 *     schema="RegisterStudentResource",
 *     required={"id", "name", "email", "type", "created_at"},
 *
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
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Student $this */
        return [
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip' => $this->zip,
            'student_parent_id' => $this->student_parent_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
            'user' => new UserResource($this->whenLoaded('user')),
            'parent' => new RegisterStudentParentResource($this->whenLoaded('parent')),
        ];
    }
}

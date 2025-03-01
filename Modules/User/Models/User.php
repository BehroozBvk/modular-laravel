<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Modules\Shared\ValueObjects\Email;
use Modules\Student\Models\Student;
use Modules\StudentParent\Models\StudentParent;
use Modules\Teacher\Models\Teacher;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Enums\UserTypeEnum;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Modules\User\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'type',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserTypeEnum::class,
        ];
    }

    /**
     * Get and set the user's email.
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => new Email($value),
            set: fn(Email|string $value) => $value instanceof Email ? (string) $value : $value,
        );
    }

    /**
     * Hash the user's password.
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => Hash::make($value),
        );
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function studentParent(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    /**
     * Check if the user is a teacher.
     */
    public function isTeacher(): bool
    {
        return $this->type === UserTypeEnum::TEACHER;
    }

    /**
     * Check if the user is a student.
     */
    public function isStudent(): bool
    {
        return $this->type === UserTypeEnum::STUDENT;
    }

    /**
     * Check if the user is a parent.
     */
    public function isParent(): bool
    {
        return $this->type === UserTypeEnum::STUDENT_PARENT;
    }

    public function getEmailForVerification(): string
    {
        return (string) $this->email;
    }

    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}

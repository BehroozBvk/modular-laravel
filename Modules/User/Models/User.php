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

/**
 * Class User
 *
 * @package Modules\User\Models
 *
 * @property string $name
 * @property Email $email
 * @property UserTypeEnum $type
 * @property string $password
 * @property \DateTimeInterface|null $email_verified_at
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected array $fillable = [
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
    protected array $hidden = [
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
     *
     * @return Attribute<Email, string>
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn(string $value): Email => new Email($value),
            set: fn(Email|string $value): string => $value instanceof Email ? (string) $value : $value,
        );
    }

    /**
     * Hash the user's password.
     *
     * @return Attribute<string, string>
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn(string $value): string => Hash::make($value),
        );
    }

    /**
     * Get the related teacher.
     *
     * @return HasOne<Teacher>
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get the related student.
     *
     * @return HasOne<Student>
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * Get the related student parent.
     *
     * @return HasOne<StudentParent>
     */
    public function studentParent(): HasOne
    {
        return $this->hasOne(StudentParent::class);
    }

    /**
     * Check if the user is a teacher.
     *
     * @return bool
     */
    public function isTeacher(): bool
    {
        return $this->type === UserTypeEnum::TEACHER;
    }

    /**
     * Check if the user is a student.
     *
     * @return bool
     */
    public function isStudent(): bool
    {
        return $this->type === UserTypeEnum::STUDENT;
    }

    /**
     * Check if the user is a parent.
     *
     * @return bool
     */
    public function isParent(): bool
    {
        return $this->type === UserTypeEnum::STUDENT_PARENT;
    }

    /**
     * Get the email for verification.
     *
     * @return string
     */
    public function getEmailForVerification(): string
    {
        return (string) $this->email;
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return UserFactory
     */
    public static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}

<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class UserPasswordResetToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'email',
        'token'
    ];

    /**
     * Create a new token for password reset
     */
    public static function createToken(string $email): self
    {
        $plainToken = Str::random(60);

        return static::create([
            'email' => $email,
            'token' => hash('sha256', $plainToken),
        ])->setAttribute('plainToken', $plainToken);
    }
}

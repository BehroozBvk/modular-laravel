<?php

declare(strict_types=1);

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminPasswordResetToken extends Model
{
    protected $table = 'admin_password_reset_tokens';

    protected $fillable = ['email', 'token'];

    public static function createToken(string $email): self
    {
        $plainToken = Str::random(60);

        return static::create([
            'email' => $email,
            'token' => hash('sha256', $plainToken),
        ])->setAttribute('plainToken', $plainToken);
    }
}

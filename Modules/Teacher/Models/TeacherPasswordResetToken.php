<?php

declare(strict_types=1);

namespace Modules\Teacher\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TeacherPasswordResetToken extends Model
{
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    public ?string $plainToken = null;

    public static function createToken(string $email): self
    {
        $token = new self();
        $token->email = $email;
        $token->plainToken = Str::random(60);
        $token->token = hash('sha256', $token->plainToken);
        $token->save();

        return $token;
    }

    public static function findValidToken(string $email, string $token): ?self
    {
        $record = static::where('email', $email)
            ->where('token', hash('sha256', $token))
            ->where('created_at', '>', Carbon::now()->subHours(1))
            ->first();

        if ($record) {
            $record->plainToken = $token;
        }

        return $record;
    }
}

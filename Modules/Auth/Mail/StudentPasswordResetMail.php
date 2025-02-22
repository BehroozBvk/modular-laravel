<?php

declare(strict_types=1);

namespace Modules\Auth\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

class StudentPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly User $user,
        private readonly string $token
    ) {}

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->markdown('auth.emails.password-reset')
            ->subject('Reset Password Notification')
            ->with([
                'user' => $this->user,
                'token' => $this->token,
                'resetUrl' => config('app.url') . '/reset-password?token=' . $this->token
            ]);
    }
}

<?php

declare(strict_types=1);

namespace Modules\Auth\Mail\StudentParent;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;
use Modules\Auth\Constants\Messages\AuthMessageConstants;

class StudentParentPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        private readonly User $user,
        private readonly string $accessToken
    ) {}

    /**
     * Build the message.
     */
    public function build(): self
    {
        $resetUrl = config('app.url') . '/reset-password?accessToken=' . $this->accessToken;

        return $this->markdown('auth.emails.password-reset')
            ->subject(AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_SUBJECT))
            ->with([
                'greeting' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_GREETING, ['name' => $this->user->name]),
                'line1' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE1),
                'actionText' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_ACTION),
                'actionUrl' => $resetUrl,
                'line2' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE2, ['count' => config('auth.passwords.users.expire')]),
                'line3' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE3),
                'footer' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_FOOTER, ['actionText' => AuthMessageConstants::get(AuthMessageConstants::STUDENT_PARENT_PASSWORD_RESET_EMAIL_ACTION)]),
            ]);
    }
}

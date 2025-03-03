<?php

declare(strict_types=1);

namespace Modules\Auth\Mail\StudentParent;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

final class StudentParentVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly User $user
    ) {}

    public function build(): self
    {
        $verificationUrl = url(route('student-parent.verification.verify', [
            'id' => $this->user->id,
            'hash' => sha1($this->user->getEmailForVerification()),
        ]));

        return $this->view('auth::emails.student-parent.verify')
            ->with([
                'verificationUrl' => $verificationUrl,
                'firstName' => $this->user->first_name,
            ]);
    }
}

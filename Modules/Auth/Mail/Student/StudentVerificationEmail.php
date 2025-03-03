<?php

declare(strict_types=1);

namespace Modules\Auth\Mail\Student;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\User\Models\User;

final class StudentVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly User $student
    ) {}

    public function build(): self
    {
        $verificationUrl = url(route('student.verification.verify', [
            'id' => $this->student->id,
            'hash' => sha1($this->student->getEmailForVerification()),
        ]));

        return $this->view('auth::emails.student.verify')
            ->with([
                'verificationUrl' => $verificationUrl,
                'firstName' => $this->student->first_name,
            ]);
    }
}

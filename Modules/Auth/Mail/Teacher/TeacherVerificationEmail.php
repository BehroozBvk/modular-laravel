<?php

declare(strict_types=1);

namespace Modules\Auth\Mail\Teacher;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Modules\Teacher\Models\Teacher;

final class TeacherVerificationEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly Teacher $teacher
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email Address',
        );
    }

    public function content(): Content
    {
        $verificationUrl = route('api.v1.auth.teachers.verify-email', [
            'id' => $this->teacher->user->id,
            'hash' => sha1($this->teacher->user->getEmailForVerification()),
        ]);

        return new Content(
            markdown: 'auth::emails.teacher.verify-email',
            with: [
                'teacher' => $this->teacher,
                'verificationUrl' => $verificationUrl,
            ],
        );
    }
}

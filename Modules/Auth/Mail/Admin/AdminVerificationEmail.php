<?php

declare(strict_types=1);

namespace Modules\Auth\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Modules\Admin\Models\Admin;

final class AdminVerificationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        private readonly Admin $admin
    ) {}

    public function build(): self
    {
        $verificationUrl = url(route('admin.verification.verify', [
            'id' => $this->admin->id,
            'hash' => sha1($this->admin->getEmailForVerification()),
        ]));

        return $this->view('auth::emails.admin.verify')
            ->with([
                'verificationUrl' => $verificationUrl,
                'firstName' => $this->admin->first_name,
            ]);
    }
}

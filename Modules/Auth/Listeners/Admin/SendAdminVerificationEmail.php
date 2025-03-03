<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Admin;

use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\Admin\AdminEmailVerificationRequested;
use Modules\Auth\Mail\Admin\AdminVerificationEmail;

final class SendAdminVerificationEmail
{
    public function handle(AdminEmailVerificationRequested $event): void
    {
        Mail::to($event->admin->email)
            ->send(new AdminVerificationEmail($event->admin));
    }
}

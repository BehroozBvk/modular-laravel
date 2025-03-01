<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Admin;

use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Auth\Mail\Admin\AdminPasswordResetMail;
use Modules\Auth\Events\Admin\AdminPasswordResetRequested;

class SendAdminPasswordResetEmail implements ShouldQueue
{
    public function handle(AdminPasswordResetRequested $event): void
    {
        Mail::to($event->admin->email)
            ->send(new AdminPasswordResetMail($event->admin, $event->token));
    }
}

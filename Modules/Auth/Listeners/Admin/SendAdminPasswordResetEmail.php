<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Admin;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Events\Admin\AdminPasswordResetRequested;
use Modules\Auth\Mail\Admin\AdminPasswordResetMail;

class SendAdminPasswordResetEmail implements ShouldQueue
{
    public function handle(AdminPasswordResetRequested $event): void
    {
        Mail::to($event->admin->email)
            ->send(new AdminPasswordResetMail($event->admin, $event->token));
    }
}

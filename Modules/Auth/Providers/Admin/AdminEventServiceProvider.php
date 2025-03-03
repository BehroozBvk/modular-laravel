<?php

declare(strict_types=1);

namespace Modules\Auth\Providers\Admin;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Modules\Auth\Events\Admin\AdminEmailVerificationRequested;
use Modules\Auth\Events\Admin\AdminEmailVerified;
use Modules\Auth\Events\Admin\AdminPasswordResetRequested;
use Modules\Auth\Listeners\Admin\AdminEmailVerifiedListener;
use Modules\Auth\Listeners\Admin\SendAdminPasswordResetEmail;
use Modules\Auth\Listeners\Admin\SendAdminVerificationEmail;

class AdminEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        AdminPasswordResetRequested::class => [
            SendAdminPasswordResetEmail::class,
        ],
        AdminEmailVerificationRequested::class => [
            SendAdminVerificationEmail::class,
        ],
        AdminEmailVerified::class => [
            AdminEmailVerifiedListener::class,
        ],
    ];
}

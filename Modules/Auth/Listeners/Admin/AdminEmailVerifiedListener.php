<?php

declare(strict_types=1);

namespace Modules\Auth\Listeners\Admin;

use Modules\Auth\Events\Admin\AdminEmailVerified;

final class AdminEmailVerifiedListener
{
    public function handle(AdminEmailVerified $event): void {}
}

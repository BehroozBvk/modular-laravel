<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Base controller class that all other controllers extend from
 */
abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}

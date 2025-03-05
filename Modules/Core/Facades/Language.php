<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Helpers\LanguageHelper;

class Language extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return LanguageHelper::class;
    }
}

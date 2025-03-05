<?php

declare(strict_types=1);

namespace Modules\Core\Helpers;

use Carbon\Carbon;

/**
 * Helper class for language-related operations
 */
class LanguageHelper
{
    /**
     * Switch the application's language
     *
     * @param string $language The language code to switch to
     * @return bool True if the language was switched successfully, false otherwise
     */
    public static function switchLanguage(string $language): bool
    {
        /** @var array<int, string> $supportedLanguages */
        $supportedLanguages = array_keys(config('languages.supported'));

        if (in_array($language, $supportedLanguages, true)) {
            app()->setLocale($language);
            Carbon::setLocale($language);
            return true;
        }

        return false;
    }

    /**
     * Get the current language of the application
     *
     * @return string The current language code
     */
    public static function getCurrentLanguage(): string
    {
        return app()->getLocale();
    }

    /**
     * Get the list of supported languages
     *
     * @return array<string, string> An associative array of supported languages
     */
    public static function getSupportedLanguages(): array
    {
        /** @var array<string, string> $supportedLanguages */
        $supportedLanguages = config('languages.supported');
        return $supportedLanguages;
    }
}

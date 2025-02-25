<?php

declare(strict_types=1);

namespace Modules\Auth\Constants\Messages;

use Illuminate\Support\Facades\Lang;

/**
 * Constants for Auth module messages
 */
final class AuthMessageConstants
{
    // Success Messages
    public const STUDENT_REGISTERED = 'auth::messages.student.registered';
    public const STUDENT_LOGGED_IN = 'auth::messages.student.logged_in';
    public const STUDENT_PASSWORD_CHANGED = 'auth::messages.success.student.password_changed';
    public const STUDENT_PASSWORD_RESET_LINK_SENT = 'auth::messages.student.password_reset_link_sent';
    public const STUDENT_EMAIL_VERIFIED = 'auth::messages.student.email_verified';
    public const STUDENT_PASSWORD_RESET_SUCCESS = 'auth::messages.student.password_reset_success';
    public const STUDENT_VERIFICATION_EMAIL_SENT = 'auth::messages.student.verification_email_sent';
    public const STUDENT_LOGGED_OUT = 'auth::messages.student.logged_out';

    // Error Messages
    public const STUDENT_INVALID_CREDENTIALS = 'auth::messages.student.invalid_credentials';
    public const STUDENT_ALREADY_REGISTERED = 'auth::messages.student.already_registered';
    public const STUDENT_NOT_FOUND = 'auth::messages.student.not_found';
    public const STUDENT_INVALID_PASSWORD = 'auth::messages.student.invalid_password';
    public const STUDENT_REGISTRATION_FAILED = 'auth::messages.student.registration_failed';
    public const STUDENT_INVALID_PASSWORD_RESET_TOKEN = 'auth::messages.student.invalid_password_reset_token';

    // Email Messages
    public const STUDENT_PASSWORD_RESET_EMAIL_SUBJECT = 'auth::messages.email.student.password_reset.subject';
    public const STUDENT_PASSWORD_RESET_EMAIL_GREETING = 'auth::messages.email.student.password_reset.greeting';
    public const STUDENT_PASSWORD_RESET_EMAIL_LINE1 = 'auth::messages.email.student.password_reset.line1';
    public const STUDENT_PASSWORD_RESET_EMAIL_ACTION = 'auth::messages.email.student.password_reset.action';
    public const STUDENT_PASSWORD_RESET_EMAIL_LINE2 = 'auth::messages.email.student.password_reset.line2';
    public const STUDENT_PASSWORD_RESET_EMAIL_LINE3 = 'auth::messages.email.student.password_reset.line3';
    public const STUDENT_PASSWORD_RESET_EMAIL_FOOTER = 'auth::messages.email.student.password_reset.footer';

    // Validation Messages
    public const VALIDATION_NAME_REQUIRED = 'auth::messages.validation.name.required';
    public const VALIDATION_NAME_REGEX = 'auth::messages.validation.name.regex';
    public const VALIDATION_EMAIL_REQUIRED = 'auth::messages.validation.email.required';
    public const VALIDATION_EMAIL_EMAIL = 'auth::messages.validation.email.email';
    public const VALIDATION_EMAIL_UNIQUE = 'auth::messages.validation.email.unique';
    public const VALIDATION_PASSWORD_REQUIRED = 'auth::messages.validation.password.required';
    public const VALIDATION_PASSWORD_CONFIRMED = 'auth::messages.validation.password.confirmed';
    public const VALIDATION_PHONE_NUMBER_REGEX = 'auth::messages.validation.phone_number.regex';
    public const VALIDATION_PHONE_NUMBER_MIN = 'auth::messages.validation.phone_number.min';
    public const VALIDATION_PHONE_NUMBER_MAX = 'auth::messages.validation.phone_number.max';
    public const VALIDATION_AVATAR_IMAGE = 'auth::messages.validation.avatar.image';
    public const VALIDATION_AVATAR_MIMES = 'auth::messages.validation.avatar.mimes';
    public const VALIDATION_AVATAR_DIMENSIONS = 'auth::messages.validation.avatar.dimensions';
    public const VALIDATION_AVATAR_MAX = 'auth::messages.validation.avatar.max';
    public const VALIDATION_COUNTRY_ID_EXISTS = 'auth::messages.validation.country_id.exists';

    // Attribute Names
    public const ATTRIBUTE_NAME = 'auth::messages.attributes.name';
    public const ATTRIBUTE_EMAIL = 'auth::messages.attributes.email';
    public const ATTRIBUTE_PASSWORD = 'auth::messages.attributes.password';
    public const ATTRIBUTE_ROLE = 'auth::messages.attributes.role';
    public const ATTRIBUTE_PHONE_NUMBER = 'auth::messages.attributes.phone_number';
    public const ATTRIBUTE_AVATAR = 'auth::messages.attributes.avatar';
    public const ATTRIBUTE_COUNTRY_ID = 'auth::messages.attributes.country_id';
    public const ATTRIBUTE_FIRST_NAME = 'auth::messages.attributes.first_name';
    public const ATTRIBUTE_LAST_NAME = 'auth::messages.attributes.last_name';

    /**
     * Get a localized message
     */
    public static function get(string $key, array $replace = []): string
    {
        return Lang::get($key, $replace);
    }
}

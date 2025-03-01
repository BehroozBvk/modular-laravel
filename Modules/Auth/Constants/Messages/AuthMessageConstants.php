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

    // Student Parent Success Messages
    public const STUDENT_PARENT_REGISTERED = 'auth::messages.student_parent.registered';

    public const STUDENT_PARENT_LOGGED_IN = 'auth::messages.student_parent.logged_in';

    public const STUDENT_PARENT_PASSWORD_CHANGED = 'auth::messages.success.student_parent.password_changed';

    public const STUDENT_PARENT_PASSWORD_RESET_LINK_SENT = 'auth::messages.student_parent.password_reset_link_sent';

    public const STUDENT_PARENT_EMAIL_VERIFIED = 'auth::messages.student_parent.email_verified';

    public const STUDENT_PARENT_PASSWORD_RESET_SUCCESS = 'auth::messages.student_parent.password_reset_success';

    public const STUDENT_PARENT_VERIFICATION_EMAIL_SENT = 'auth::messages.student_parent.verification_email_sent';

    public const STUDENT_PARENT_LOGGED_OUT = 'auth::messages.student_parent.logged_out';

    // Admin Success Messages
    public const ADMIN_REGISTERED = 'auth::messages.success.admin_registered';

    public const ADMIN_LOGGED_IN = 'auth::messages.success.admin_logged_in';

    public const ADMIN_LOGGED_OUT = 'auth::messages.success.admin_logged_out';

    public const ADMIN_PASSWORD_CHANGED = 'auth::messages.success.admin_password_changed';

    public const ADMIN_PASSWORD_RESET_LINK_SENT = 'auth::messages.success.admin_password_reset_link_sent';

    public const ADMIN_PASSWORD_RESET = 'auth::messages.success.admin_password_reset';

    public const ADMIN_EMAIL_VERIFIED = 'auth::messages.success.admin_email_verified';

    public const ADMIN_EMAIL_VERIFICATION_LINK_SENT = 'auth::messages.success.admin_email_verification_link_sent';

    public const ADMIN_VERIFICATION_EMAIL_SENT = 'auth::messages.success.admin_verification_email_sent';

    public const ADMIN_PASSWORD_RESET_SUCCESS = 'auth::messages.success.admin_password_reset_success';

    // Error Messages
    public const STUDENT_INVALID_CREDENTIALS = 'auth::messages.student.invalid_credentials';

    public const STUDENT_ALREADY_REGISTERED = 'auth::messages.student.already_registered';

    public const STUDENT_NOT_FOUND = 'auth::messages.student.not_found';

    public const STUDENT_INVALID_PASSWORD = 'auth::messages.student.invalid_password';

    public const STUDENT_REGISTRATION_FAILED = 'auth::messages.student.registration_failed';

    public const STUDENT_INVALID_PASSWORD_RESET_TOKEN = 'auth::messages.student.invalid_password_reset_token';

    public const STUDENT_EMAIL_ALREADY_VERIFIED = 'auth::messages.student.email_already_verified';

    public const STUDENT_INVALID_EMAIL_VERIFICATION_LINK = 'auth::messages.student.invalid_email_verification_link';

    public const ADMIN_INVALID_PASSWORD_RESET_TOKEN = 'auth::messages.admin.invalid_password_reset_token';

    // Student Parent Error Messages
    public const STUDENT_PARENT_INVALID_CREDENTIALS = 'auth::messages.student_parent.invalid_credentials';

    public const STUDENT_PARENT_ALREADY_REGISTERED = 'auth::messages.student_parent.already_registered';

    public const STUDENT_PARENT_NOT_FOUND = 'auth::messages.student_parent.not_found';

    public const STUDENT_PARENT_INVALID_PASSWORD = 'auth::messages.student_parent.invalid_password';

    public const STUDENT_PARENT_REGISTRATION_FAILED = 'auth::messages.student_parent.registration_failed';

    public const STUDENT_PARENT_INVALID_PASSWORD_RESET_TOKEN = 'auth::messages.student_parent.invalid_password_reset_token';

    public const STUDENT_PARENT_EMAIL_ALREADY_VERIFIED = 'auth::messages.student_parent.email_already_verified';

    public const STUDENT_PARENT_INVALID_EMAIL_VERIFICATION_LINK = 'auth::messages.student_parent.invalid_email_verification_link';

    // Admin Error Messages
    public const ADMIN_INVALID_CREDENTIALS = 'auth::messages.error.admin_invalid_credentials';

    public const ADMIN_ACCOUNT_NOT_VERIFIED = 'auth::messages.error.admin_account_not_verified';

    public const ADMIN_INVALID_TOKEN = 'auth::messages.error.admin_invalid_token';

    public const ADMIN_INVALID_SIGNATURE = 'auth::messages.error.admin_invalid_signature';

    public const ADMIN_EXPIRED_URL = 'auth::messages.error.admin_expired_url';

    public const ADMIN_EMAIL_ALREADY_VERIFIED = 'auth::messages.error.admin_email_already_verified';

    public const ADMIN_NOT_FOUND = 'auth::messages.error.admin_not_found';

    public const ADMIN_INVALID_EMAIL_VERIFICATION_LINK = 'auth::messages.error.admin_invalid_email_verification_link';

    public const ADMIN_ALREADY_REGISTERED = 'auth::messages.error.admin_already_registered';

    public const ADMIN_INVALID_PASSWORD = 'auth::messages.error.admin_invalid_password';

    public const ADMIN_REGISTRATION_FAILED = 'auth::messages.error.admin_registration_failed';

    // Email Messages
    public const STUDENT_PASSWORD_RESET_EMAIL_SUBJECT = 'auth::messages.email.student.password_reset.subject';

    public const STUDENT_PASSWORD_RESET_EMAIL_GREETING = 'auth::messages.email.student.password_reset.greeting';

    public const STUDENT_PASSWORD_RESET_EMAIL_LINE1 = 'auth::messages.email.student.password_reset.line1';

    public const STUDENT_PASSWORD_RESET_EMAIL_ACTION = 'auth::messages.email.student.password_reset.action';

    public const STUDENT_PASSWORD_RESET_EMAIL_LINE2 = 'auth::messages.email.student.password_reset.line2';

    public const STUDENT_PASSWORD_RESET_EMAIL_LINE3 = 'auth::messages.email.student.password_reset.line3';

    public const STUDENT_PASSWORD_RESET_EMAIL_FOOTER = 'auth::messages.email.student.password_reset.footer';

    // Student Parent Email Messages
    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_SUBJECT = 'auth::messages.email.student_parent.password_reset.subject';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_GREETING = 'auth::messages.email.student_parent.password_reset.greeting';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE1 = 'auth::messages.email.student_parent.password_reset.line1';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_ACTION = 'auth::messages.email.student_parent.password_reset.action';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE2 = 'auth::messages.email.student_parent.password_reset.line2';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_LINE3 = 'auth::messages.email.student_parent.password_reset.line3';

    public const STUDENT_PARENT_PASSWORD_RESET_EMAIL_FOOTER = 'auth::messages.email.student_parent.password_reset.footer';

    // Admin Email Messages
    public const ADMIN_PASSWORD_RESET_EMAIL_SUBJECT = 'auth::messages.email.admin.password_reset.subject';

    public const ADMIN_PASSWORD_RESET_EMAIL_GREETING = 'auth::messages.email.admin.password_reset.greeting';

    public const ADMIN_PASSWORD_RESET_EMAIL_LINE1 = 'auth::messages.email.admin.password_reset.line1';

    public const ADMIN_PASSWORD_RESET_EMAIL_ACTION = 'auth::messages.email.admin.password_reset.action';

    public const ADMIN_PASSWORD_RESET_EMAIL_LINE2 = 'auth::messages.email.admin.password_reset.line2';

    public const ADMIN_PASSWORD_RESET_EMAIL_LINE3 = 'auth::messages.email.admin.password_reset.line3';

    public const ADMIN_PASSWORD_RESET_EMAIL_FOOTER = 'auth::messages.email.admin.password_reset.footer';

    // Teacher Email Messages
    public const TEACHER_PASSWORD_RESET_EMAIL_SUBJECT = 'auth::messages.email.teacher.password_reset.subject';

    public const TEACHER_PASSWORD_RESET_EMAIL_GREETING = 'auth::messages.email.teacher.password_reset.greeting';

    public const TEACHER_PASSWORD_RESET_EMAIL_LINE1 = 'auth::messages.email.teacher.password_reset.line1';

    public const TEACHER_PASSWORD_RESET_EMAIL_ACTION = 'auth::messages.email.teacher.password_reset.action';

    public const TEACHER_PASSWORD_RESET_EMAIL_LINE2 = 'auth::messages.email.teacher.password_reset.line2';

    public const TEACHER_PASSWORD_RESET_EMAIL_LINE3 = 'auth::messages.email.teacher.password_reset.line3';

    public const TEACHER_PASSWORD_RESET_EMAIL_FOOTER = 'auth::messages.email.teacher.password_reset.footer';

    // Validation Messages
    public const VALIDATION_NAME_REQUIRED = 'auth::messages.validation.name.required';

    public const VALIDATION_NAME_REGEX = 'auth::messages.validation.name.regex';

    public const VALIDATION_EMAIL_REQUIRED = 'auth::messages.validation.email.required';

    public const VALIDATION_EMAIL_EMAIL = 'auth::messages.validation.email.email';

    public const VALIDATION_EMAIL_UNIQUE = 'auth::messages.validation.email.unique';

    public const VALIDATION_EMAIL_EXISTS = 'auth::messages.validation.email.exists';

    public const VALIDATION_PASSWORD_REQUIRED = 'auth::messages.validation.password.required';

    public const VALIDATION_PASSWORD_CONFIRMED = 'auth::messages.validation.password.confirmed';

    public const VALIDATION_TOKEN_REQUIRED = 'auth::messages.validation.token.required';

    public const VALIDATION_CURRENT_PASSWORD_REQUIRED = 'auth::messages.validation.current_password.required';

    public const VALIDATION_CURRENT_PASSWORD_MATCH = 'auth::messages.validation.current_password.match';

    public const VALIDATION_NEW_PASSWORD_DIFFERENT = 'auth::messages.validation.new_password.different';

    public const VALIDATION_PHONE_NUMBER_REGEX = 'auth::messages.validation.phone_number.regex';

    public const VALIDATION_PHONE_NUMBER_MIN = 'auth::messages.validation.phone_number.min';

    public const VALIDATION_PHONE_NUMBER_MAX = 'auth::messages.validation.phone_number.max';

    public const VALIDATION_AVATAR_IMAGE = 'auth::messages.validation.avatar.image';

    public const VALIDATION_AVATAR_MIMES = 'auth::messages.validation.avatar.mimes';

    public const VALIDATION_AVATAR_DIMENSIONS = 'auth::messages.validation.avatar.dimensions';

    public const VALIDATION_AVATAR_MAX = 'auth::messages.validation.avatar.max';

    public const VALIDATION_COUNTRY_ID_EXISTS = 'auth::messages.validation.country_id.exists';

    public const VALIDATION_ID_REQUIRED = 'auth::messages.validation.id.required';

    public const VALIDATION_ID_EXISTS = 'auth::messages.validation.id.exists';

    public const VALIDATION_HASH_REQUIRED = 'auth::messages.validation.hash.required';

    public const VALIDATION_SIGNATURE_REQUIRED = 'auth::messages.validation.signature.required';

    public const VALIDATION_EXPIRES_REQUIRED = 'auth::messages.validation.expires.required';

    public const VALIDATION_NAME_MIN = 'auth::messages.validation.name.min';

    public const VALIDATION_PASSWORD_MIN = 'auth::messages.validation.password.min';

    // Attribute Names
    public const ATTRIBUTE_NAME = 'auth::messages.attributes.name';

    public const ATTRIBUTE_EMAIL = 'auth::messages.attributes.email';

    public const ATTRIBUTE_PASSWORD = 'auth::messages.attributes.password';

    public const ATTRIBUTE_TOKEN = 'auth::messages.attributes.token';

    public const ATTRIBUTE_CURRENT_PASSWORD = 'auth::messages.attributes.current_password';

    public const ATTRIBUTE_ROLE = 'auth::messages.attributes.role';

    public const ATTRIBUTE_PHONE_NUMBER = 'auth::messages.attributes.phone_number';

    public const ATTRIBUTE_AVATAR = 'auth::messages.attributes.avatar';

    public const ATTRIBUTE_COUNTRY_ID = 'auth::messages.attributes.country_id';

    public const ATTRIBUTE_FIRST_NAME = 'auth::messages.attributes.first_name';

    public const ATTRIBUTE_LAST_NAME = 'auth::messages.attributes.last_name';

    public const ATTRIBUTE_NEW_PASSWORD = 'auth::messages.attributes.new_password';

    public const ATTRIBUTE_ID = 'auth::messages.attributes.id';

    public const ATTRIBUTE_HASH = 'auth::messages.attributes.hash';

    public const ATTRIBUTE_SIGNATURE = 'auth::messages.attributes.signature';

    public const ATTRIBUTE_EXPIRES = 'auth::messages.attributes.expires';

    // Teacher Success Messages
    public const TEACHER_REGISTERED = 'auth::messages.success.teacher_registered';

    public const TEACHER_LOGGED_IN = 'auth::messages.success.teacher_logged_in';

    public const TEACHER_LOGGED_OUT = 'auth::messages.success.teacher_logged_out';

    public const TEACHER_PASSWORD_CHANGED = 'auth::messages.success.teacher_password_changed';

    public const TEACHER_PASSWORD_RESET_LINK_SENT = 'auth::messages.success.teacher_password_reset_link_sent';

    public const TEACHER_PASSWORD_RESET = 'auth::messages.success.teacher_password_reset';

    public const TEACHER_EMAIL_VERIFIED = 'auth::messages.success.teacher_email_verified';

    public const TEACHER_EMAIL_VERIFICATION_LINK_SENT = 'auth::messages.success.teacher_email_verification_link_sent';

    public const TEACHER_VERIFICATION_EMAIL_SENT = 'auth::messages.success.teacher_verification_email_sent';

    // Teacher Error Messages
    public const TEACHER_INVALID_CREDENTIALS = 'auth::messages.error.teacher_invalid_credentials';

    public const TEACHER_ACCOUNT_NOT_VERIFIED = 'auth::messages.error.teacher_account_not_verified';

    public const TEACHER_INVALID_TOKEN = 'auth::messages.error.teacher_invalid_token';

    public const TEACHER_INVALID_SIGNATURE = 'auth::messages.error.teacher_invalid_signature';

    public const TEACHER_EXPIRED_URL = 'auth::messages.error.teacher_expired_url';

    public const TEACHER_NOT_FOUND = 'auth::messages.error.teacher_not_found';

    public const TEACHER_INVALID_EMAIL_VERIFICATION_LINK = 'auth::messages.error.teacher_invalid_email_verification_link';

    public const TEACHER_ALREADY_REGISTERED = 'auth::messages.error.teacher_already_registered';

    public const TEACHER_INVALID_PASSWORD = 'auth::messages.error.teacher_invalid_password';

    public const TEACHER_REGISTRATION_FAILED = 'auth::messages.error.teacher_registration_failed';

    // Add these constants to the class:
    public const TEACHER_PASSWORD_RESET_SUCCESS = 'teacher.password_reset_success';

    public const TEACHER_INVALID_RESET_TOKEN = 'teacher.invalid_reset_token';

    public const TEACHER_EMAIL_ALREADY_VERIFIED = 'teacher.email_already_verified';

    private static array $messages = [
        // ... existing code ...

        // Validation Messages
        self::VALIDATION_CURRENT_PASSWORD_REQUIRED => 'The current password is required.',
        self::VALIDATION_CURRENT_PASSWORD_MATCH => 'The current password is incorrect.',
        self::VALIDATION_NEW_PASSWORD_DIFFERENT => 'The new password must be different from your current password.',
        self::VALIDATION_ID_REQUIRED => 'The ID field is required.',
        self::VALIDATION_ID_EXISTS => 'The selected ID is invalid.',
        self::VALIDATION_HASH_REQUIRED => 'The hash field is required.',
        self::VALIDATION_SIGNATURE_REQUIRED => 'The signature field is required.',
        self::VALIDATION_EXPIRES_REQUIRED => 'The expiration timestamp is required.',

        // Attributes
        self::ATTRIBUTE_CURRENT_PASSWORD => 'current password',
        self::ATTRIBUTE_NEW_PASSWORD => 'new password',
        self::ATTRIBUTE_ID => 'ID',
        self::ATTRIBUTE_HASH => 'hash',
        self::ATTRIBUTE_SIGNATURE => 'signature',
        self::ATTRIBUTE_EXPIRES => 'expiration timestamp',

        // Teacher Success Messages
        self::TEACHER_REGISTERED => 'Teacher registered successfully.',
        self::TEACHER_LOGGED_IN => 'Teacher logged in successfully.',
        self::TEACHER_LOGGED_OUT => 'Teacher logged out successfully.',
        self::TEACHER_PASSWORD_CHANGED => 'Teacher password changed successfully.',
        self::TEACHER_PASSWORD_RESET_LINK_SENT => 'Password reset link sent to your email.',
        self::TEACHER_PASSWORD_RESET => 'Teacher password reset successfully.',
        self::TEACHER_EMAIL_VERIFIED => 'Teacher email verified successfully.',
        self::TEACHER_EMAIL_VERIFICATION_LINK_SENT => 'Email verification link sent.',

        // Teacher Error Messages
        self::TEACHER_INVALID_CREDENTIALS => 'Invalid credentials.',
        self::TEACHER_ACCOUNT_NOT_VERIFIED => 'Your account is not verified.',
        self::TEACHER_INVALID_TOKEN => 'Invalid token.',
        self::TEACHER_INVALID_SIGNATURE => 'Invalid signature.',
        self::TEACHER_EXPIRED_URL => 'URL has expired.',
        self::TEACHER_EMAIL_ALREADY_VERIFIED => 'Email is already verified.',
        self::TEACHER_NOT_FOUND => 'Teacher not found.',
        self::TEACHER_INVALID_EMAIL_VERIFICATION_LINK => 'Invalid email verification link.',
        self::TEACHER_ALREADY_REGISTERED => 'Teacher is already registered.',
        self::TEACHER_INVALID_PASSWORD => 'Invalid password.',
        self::TEACHER_REGISTRATION_FAILED => 'Teacher registration failed.',
    ];

    /**
     * Get a localized message
     */
    public static function get(string $key, array $replace = []): string
    {
        return Lang::get($key, $replace);
    }
}

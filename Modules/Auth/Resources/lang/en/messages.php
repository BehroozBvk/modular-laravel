<?php

return [
    'success' => [
        'student' => [
            'registered' => 'Student registered successfully.',
            'logged_in' => 'Student logged in successfully.',
            'logged_out' => 'Student logged out successfully.',
            'password_changed' => 'Password changed successfully!',
            'password_reset_link_sent' => 'Password reset link has been sent to your email.',
            'password_reset_success' => 'Password has been reset successfully.',
            'email_verified' => 'Email verified successfully.',
        ],
    ],
    'error' => [
        'student' => [
            'invalid_credentials' => 'Invalid email or password.',
            'already_registered' => 'Student with this email already exists.',
            'not_found' => 'Student not found.',
            'invalid_password' => 'Current password is incorrect.',
            'registration_failed' => 'Failed to register student.',
            'invalid_password_reset_token' => 'Invalid or expired password reset token.',
            'email_already_verified' => 'Email is already verified.',
            'invalid_email_verification_link' => 'Invalid email verification link.',
        ],
    ],
    'email' => [
        'student' => [
            'password_reset' => [
                'subject' => 'Reset Password Notification',
                'greeting' => 'Hello :name,',
                'line1' => 'You are receiving this email because we received a password reset request for your account.',
                'action' => 'Reset Password',
                'line2' => 'This password reset link will expire in :count minutes.',
                'line3' => 'If you did not request a password reset, no further action is required.',
                'footer' => "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below into your web browser:",
            ],
        ],
    ],
    'validation' => [
        'name' => [
            'required' => 'The name field is required.',
            'regex' => 'The name may only contain letters, spaces, and hyphens.',
        ],
        'email' => [
            'required' => 'The email field is required.',
            'email' => 'The email must be a valid email address.',
            'unique' => 'The email has already been taken.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'confirmed' => 'The password confirmation does not match.',
        ],
        'phone_number' => [
            'regex' => 'Invalid phone number format.',
            'min' => 'Phone number must be at least 10 characters.',
            'max' => 'Phone number must not exceed 20 characters.',
        ],
        'avatar' => [
            'image' => 'The file must be an image.',
            'mimes' => 'The image must be a file of type: jpg, png, jpeg, gif, or svg.',
            'dimensions' => 'Image dimensions must be between 100x100 and 1000x1000 pixels.',
            'max' => 'The image must not be larger than 2MB.',
        ],
        'country_id' => [
            'exists' => 'Selected country does not exist.',
        ],
    ],
    'attributes' => [
        'name' => 'full name',
        'email' => 'email address',
        'password' => 'password',
        'role' => 'user role',
        'phone_number' => 'phone number',
        'avatar' => 'profile avatar',
        'country_id' => 'country',
        'first_name' => 'first name',
        'last_name' => 'last name',
    ],
];

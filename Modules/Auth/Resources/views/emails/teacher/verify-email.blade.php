@component('mail::message')
# Verify Your Email Address

Dear {{ $teacher->first_name }},

Thank you for registering as a teacher. Please click the button below to verify your email address.

@component('mail::button', ['url' => $verificationUrl, 'color' => 'primary'])
Verify Email Address
@endcomponent

If you did not create an account, no further action is required.

Best regards,<br>
{{ config('app.name') }}

@slot('footer')
© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
@endslot
@endcomponent
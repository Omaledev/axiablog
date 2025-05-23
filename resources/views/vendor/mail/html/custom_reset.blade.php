@component('mail::message')
<!-- Logo inside body -->
<div style="text-align: center; margin-bottom: 20px;">
    <a href="{{ config('app.url') }}">
        <img src="{{ $logo }}" width="150" alt="AXIA HUB Logo">
    </a>
</div>

# Hello {{ $name }}!

You requested a password reset for your **AXIA HUB** account.
Please click the link below to reset your password.

@component('mail::button', ['url' => $resetUrl])
Reset Password
@endcomponent

This link expires in 60 minutes.

If you didn't request this, please ignore this email.

Regards,
**AXIA HUB Team**
@endcomponent

@component('mail::message')
{{ $greeting }}

{{ $line1 }}

@component('mail::button', ['url' => $actionUrl])
{{ $actionText }}
@endcomponent

{{ $line2 }}

{{ $line3 }}

@component('mail::subcopy')
{{ $footer }}
<br>
<span style="word-break: break-all;">{{ $actionUrl }}</span>
@endcomponent

@endcomponent
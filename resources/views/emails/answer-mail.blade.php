@component('mail::panel')
@component('mail::message')
    <p>
        {{ $details->body ?? '' }}
    </p>
@endcomponent

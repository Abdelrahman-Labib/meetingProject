@component('mail::message')
# Meeting Details

Name : {{ $data["name"] }}
Start time : {{ $data["start_datetime"] }}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

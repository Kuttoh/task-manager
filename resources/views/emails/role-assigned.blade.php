@component('mail::message')

    You've been assigned a new role: <strong>{{ $user->role->name }}</strong>

    Assigned by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}

    Thanks,
    {{ config('app.name') }}
@endcomponent

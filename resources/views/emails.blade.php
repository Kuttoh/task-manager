@component('mail::message')

    You've been assigned a new role: <strong>{{ $user->role->name }}</strong>

    Assigned by: <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

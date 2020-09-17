@component('mail::message')

    You've been assigned as project lead for: <strong>{{ $project->name }}</strong>

    Assigned by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}

    Thanks,
    {{ config('app.name') }}
@endcomponent

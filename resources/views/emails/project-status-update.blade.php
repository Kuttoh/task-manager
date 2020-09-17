@component('mail::message')

    The project <strong>{{ $project->name }}</strong> has been marked as <strong>{{ $project->status->name }}</strong>

    Edited by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}

    Thanks,
    {{ config('app.name') }}
@endcomponent

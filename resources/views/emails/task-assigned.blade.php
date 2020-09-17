@component('mail::message')

    You've been assigned a task with the following details <br>
    Title: <strong>{{ $task->title }}</strong> <br>
    Start Date: <strong>{{ $task->start_date }}</strong> <br>
    End Date: <strong>{{ $task->end_date }}</strong> <br>
    Description: <strong>{{ $task->description }}</strong> <br>
    Priority: <strong>{{ $task->priority->name }}</strong>

    Assigned by: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}

    Thanks,
    {{ config('app.name') }}
@endcomponent

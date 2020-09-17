@component('mail::message')

    The task with the following details is expiring today <br>
    Title: <strong>{{ $task->title }}</strong> <br>
    Start Date: <strong>{{ $task->start_date }}</strong> <br>
    End Date: <strong>{{ $task->end_date }}</strong> <br>
    Description: <strong>{{ $task->description }}</strong> <br>
    Priority: <strong>{{ $task->priority->name }}</strong>

    Thanks,
    {{ config('app.name') }}
@endcomponent

@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Project Tasks</h3>
            <a href="/tasks/create/{{ $project->id }}" class="btn btn-outline-success float-right ml-auto mb-1">Add Task</a>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Assigned To</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->assignee->last_name }} {{ $task->assignee->first_name }}</td>
                        <td>{{ $task->start_date }}</td>
                        <td>{{ $task->end_date }}</td>
                        <td>{{ $task->status->name }}</td>
                        <td>
                            <a href="{{$task->path()}}">
                                <button type="submit" class="btn btn-outline-dark"><i class="fa fa-eye"></i> </button>
                            </a>
{{--                            @if($task->status->slug != 'done' and $task->assignee->id == auth()->id())--}}
{{--                                <a href="{{$task->path()}}/edit">--}}
{{--                                    <button type="submit" class="btn btn-outline-info"><i class="fa fa-edit"></i> </button>--}}
{{--                                </a>--}}
{{--                            @endif--}}
                            @if($task->status->slug == 'done' and $task->project->projectLead->id == auth()->id())
                                <a href="{{$task->path()}}/delete">
                                    <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i> </button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $tasks->links() }}
        </div>
    </div>

@endsection

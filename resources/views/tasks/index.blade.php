@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <h3>Task Details</h3>
        <div class="row just">
            <div class="col-md-8">

                <div class="form-group">
                    <a href="/tasks/{{ $task->id }}/edit" class="btn btn-outline-dark">Edit</a>
                </div>

                <div class="card" style="margin-bottom:10px">
                    <div class="card-header text-white" style="background-color: #9561e2">
                        <h5>Title: {{ $task->title }}</h5>
                    </div>
                    <div class="card-body">
                        {{$task->description}}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card" style="margin-bottom:10px">
                    <div class="card-header bg-info text-white">Task Information</div>
                    <div class="card-body">
                        <p>Assigned
                            to: {{ $task->assignee->first_name }} {{ $task->assignee->last_name }}</p>
                        <p>Status: {{ $task->status->name }}</p>
                        <p>Priority: {{ $task->priority->name }}</p>
                        <p>Start Date: {{ $task->start_date }}</p>
                        <p>End Date: {{ $task->end_date }}</p>
                    </div>
                </div>

                @if(auth()->check())
                    <div class="card" style="margin-bottom:10px">
                        <div class="card-header bg-info text-white">Project Information</div>
                        <div class="card-body">
                            <p>Name: {{ $task->project->name }} </p>
                            <p>Lead: {{ $task->project->projectLead->first_name }} {{ $task->project->projectLead->last_name }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

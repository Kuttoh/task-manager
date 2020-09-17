@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Edit Task</div>

                    @if ($errors->any())
                        <div class="notification is-danger text-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">

                        <form method="POST" action="{{ $task->path() }}/update">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input name="title" type="text" class="form-control" id="title"
                                       value="{{ $task->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Task Description:</label>
                                <input type="text" class="form-control" id="description" name="description"
                                           value="{{ $task->description }}" required>
                            </div>

                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                       value="{{ $task->start_date }}" required>
                            </div>

                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                       value="{{ $task->end_date }}" required>{{ old('end_date') }}
                            </div>

                            <div class="form-group">
                                <label for="user_id">Assign To:</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id}}" {{ $task->assignee->id == $user->id ? 'selected': '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="task_priority_id">Update Priority:</label>
                                <select name="task_priority_id" id="task_priority_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($priorities as $priority)
                                        <option value="{{ $priority->id}}" {{ $task->priority->id == $priority->id ? 'selected': '' }}>
                                            {{ $priority->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="project_status_id">Update Status:</label>
                                <select name="project_status_id" id="project_status_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id}}" {{ $task->status->id == $status->id ? 'selected': '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-dark">Edit</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



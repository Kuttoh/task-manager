@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Edit Project</div>

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

                        <form method="POST" action="{{ $project->path() }}/update">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input name="name" type="text" class="form-control" id="name"
                                       value="{{ $project->name }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Brief Description:</label>
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{ $project->description }}" required>
                            </div>

                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                       value="{{ $project->start_date }}" required>
                            </div>

                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                >{{ $project->end_date }}
                            </div>

                            <div class="form-group">
                                <label for="project_lead">Select Project Lead:</label>
                                <select name="project_lead" id="project_lead" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id}}" {{ $project->project_lead == $user->id ? 'selected': '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="project_status_id">Update Status:</label>
                                <select name="project_status_id" id="project_status_id" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id}}" {{ $project->project_status_id == $status->id ? 'selected': '' }}>
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



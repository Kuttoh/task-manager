@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Create A New Project</div>

                    @if ($errors->any())
                        <div class="notification is-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">

                        <form method="POST" action="{{ route('project.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input name="name" type="text" class="form-control" id="name"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Brief Description:</label>
                                <input type="text" class="form-control" id="description" name="description"
                                          required>{{ old('description') }}
                            </div>

                            <div class="form-group">
                                <label for="start_date">Start Date:</label>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                           required>{{ old('start_date') }}
                            </div>

                            <div class="form-group">
                                <label for="end_date">End Date:</label>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                          >{{ old('end_date') }}
                            </div>

                            <div class="form-group">
                                <label for="project_lead">Select Project Lead:</label>
                                <select name="project_lead" id="project_lead" class="form-control" required>
                                    <option value="">Choose One...</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id}}" {{ old('project_lead') == $user->id ? 'selected': '' }}>
                                            {{ $user->first_name }} {{ $user->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-dark">Create</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



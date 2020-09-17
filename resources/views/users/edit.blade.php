@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">Edit User</div>

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

                        <form method="post" action="{{$user->path()}}/update">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input name="first_name" type="text" class="form-control" id="first_name" required
                                       value="{{ $user->first_name }}">
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input name="last_name" type="text" class="form-control" id="last_name" required
                                       value="{{ $user->last_name }}">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail:</label>
                                <input name="email" type="text" class="form-control" id="email" required
                                       value="{{ $user->email }}">
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

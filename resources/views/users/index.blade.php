@extends('layouts.app')

@section('content')

    <div class="container" style="margin-top: 10px">
        <div class="row">
            <h3 class="text-right">Users</h3>
            <a href="{{ route('register') }}" class="btn btn-outline-success float-right ml-auto mb-1">Add User</a>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Role</th>
{{--                    <th scope="col">Date Created</th>--}}
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
{{--                        <td>{{ $user->created_at }}</td>--}}
                        <td>
                            <a href="{{ $user->path() }}/edit">
                                <button type="submit" class="btn btn-outline-info"><i class="fa fa-edit"></i> </button>
                            </a>
                            @if($user->role->slug != 'admin')
                                <a href="{{ $user->path() }}/makeAdmin">
                                    <button type="submit" class="btn btn-outline-danger"> Make Admin</button>
                                </a>
                            @elseif(auth()->id() != $user->id)
                                <a href="{{ $user->path() }}/makeUser">
                                    <button type="submit" class="btn btn-outline-dark"> Make User</button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>
    </div>

@endsection

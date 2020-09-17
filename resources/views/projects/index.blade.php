@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top: 10px">
        <div class="row justify-content-center">
            <h3>Projects</h3>
            <a href="{{ route('project.create') }}" class="btn btn-outline-success float-right ml-auto mb-1">Add Project</a>
            <table class="table table-responsive-md table-striped">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Lead</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->name }}</td>
                        <td>{{ $project->projectLead->last_name }} {{ $project->projectLead->first_name }}</td>
                        <td>{{ $project->start_date }}</td>
                        <td>{{ $project->end_date }}</td>
                        <td>{{ $project->status->name }}</td>
                        <td>
                            <a href="{{$project->path()}}">
                                <button type="submit" class="btn btn-outline-dark"><i class="fa fa-eye"></i> </button>
                            </a>
                            @if($project->status->slug != 'done' and $project->projectLead->id == auth()->id())
                                <a href="{{$project->path()}}/edit">
                                    <button type="submit" class="btn btn-outline-info"><i class="fa fa-edit"></i> </button>
                                </a>
                            @endif
                            @if($project->status->slug == 'done' and $project->projectLead->id == auth()->id())
                                <a href="{{$project->path()}}/delete">
                                    <button type="submit" class="btn btn-outline-danger"><i class="fa fa-trash"></i> </button>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $projects->links() }}
        </div>
    </div>

@endsection

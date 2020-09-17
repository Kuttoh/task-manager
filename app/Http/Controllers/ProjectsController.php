<?php

namespace App\Http\Controllers;

use App\Mail\ProjectAssigned;
use App\Mail\ProjectStatusUpdate;
use App\Project;
use App\ProjectMember;
use App\ProjectStatus;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectsController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        $projects = Project::paginate(10);

        return view('projects.index', compact('projects'));
    }


    public function create()
    {
        $users = User::all();

        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'project_lead' => 'required|integer',
            'start_date' => 'required|date',
        ]);

        $input = $request->except('_token');

        $start = Carbon::parse($input['start_date']);

        $end = isset($input['end_date']) ? Carbon::parse($input['end_date']) : null;

        if ($end && $start->gt($end)) {
            return back()->with('error', 'Project cannot end before starting');
        }

        $input = array_add($input, 'project_status_id', 1);

        $project = new Project();
        $project->fill($input);
        $project->save();
        $project->fresh();

        $projectMember = new ProjectMember();
        $projectMember->user_id = $input['project_lead'];
        $projectMember->project_id = $project->id;
        $projectMember->save();

        return back()->with('success', 'Project saved successfully!');
    }

    public function show($project_id)
    {
        $tasks = Task::where('project_id', $project_id)->paginate(10);

        return view('projects.show', ['tasks' => $tasks]);
    }

    public function edit($project_id)
    {
        $project = Project::findOrFail($project_id);

        if (auth()->id() != $project->project_lead) {
            return back()->with('error', 'Access Denied');
        }

        $users = User::all();

        $statuses = ProjectStatus::all();

        return view('projects.edit', ['project' => $project, 'users' => $users, 'statuses' => $statuses]);
    }

    public function update(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'project_lead' => 'required|integer',
            'start_date' => 'required|date',
            'project_status_id' => 'required|integer',
        ]);

        $input = $request->except('_token');

        $start = Carbon::parse($input['start_date']);

        $end = isset($input['end_date']) ? Carbon::parse($input['end_date']) : null;

        if ($end && $start->gt($end)) {
            return back()->with('error', 'Project cannot end before starting');
        }

        if ($project->project_lead != $input['project_lead']) {
            $this->sendAssignMail($input['project_lead'], $project->id);
        }

        $project->update([
            'name' => $input['name'],
            'description' => $input['description'],
            'project_lead' => $input['project_lead'],
            'project_status_id' => $input['project_status_id'],
            'start_date' => $input['start_date'],
            'end_date' => isset($input['end_date']) ? $input['end_date'] : null,
        ]);

        $this->sendStatusUpdateMail($project->project_lead, $project->id);

        return redirect('projects')->with('success', 'Project has been updated');
    }


    public function destroy($project_id)
    {
        $project = Project::findOrFail($project_id);

        //TODO add check for pending project tasks
        //if project has tasks that are pending, reject delete or mark all as done the delete project.

        $project->delete();

        return redirect('projects')->with('success', 'Project has been deleted');
    }

    protected function sendAssignMail($userId, $projectId): void
    {
        $user = User::findOrFail($userId);

        $project = Project::findOrFail($projectId);

        Mail::to($user->email)
            ->cc('admin@task-manager.com')
            ->queue(new ProjectAssigned($project));
    }

    protected function sendStatusUpdateMail($userId, $projectId): void
    {
        $user = User::findOrFail($userId);

        $project = Project::findOrFail($projectId);

        Mail::to($user->email)
            ->cc('admin@task-manager.com')
            ->queue(new ProjectStatusUpdate($project));
    }
}

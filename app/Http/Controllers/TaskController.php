<?php

namespace App\Http\Controllers;

use App\Mail\TaskAssigned;
use App\Project;
use App\ProjectMember;
use App\Task;
use App\TaskPriority;
use App\TaskStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function index()
    {

    }


    public function create($project_id)
    {
        $users = User::all();

        $project = Project::findOrFail($project_id);

        $priorities = TaskPriority::all();

        return view('tasks.create', ['users' => $users, 'project' => $project, 'priorities' => $priorities]);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        $start = Carbon::parse($input['start_date']);

        $end = isset($input['end_date']) ? Carbon::parse($input['end_date']) : null;

        if ($end && $start->gt($end)) {
            return back()->with('error', 'Task cannot end before starting');
        }

        $input = array_add($input, 'task_status_id', 1);

        $task = new  Task();
        $task->fill($input);
        $task->save();
        $task->fresh();

        $this->link($input);

        $this->sendAssignMail($input['user_id'], $task->id);

        return back()->with('success', 'Task saved successfully!');
    }

    public function show($task_id)
    {
        $task =  Task::findOrFail($task_id);

        return view('tasks.index', ['task' => $task]);
    }

    public function edit($task_id)
    {
        $task = Task::findOrFail($task_id);

        $users = User::all();

        $priorities = TaskPriority::all();

        $statuses  = TaskStatus::all();

        return view('tasks.edit', ['task' => $task, 'users' => $users, 'priorities' => $priorities, 'statuses' => $statuses]);
    }

    public function update(Request $request, $task_id)
    {
       $task = Task::findOrFail($task_id);

        $input = $request->except('_token');

        $start = Carbon::parse($input['start_date']);

        $end = isset($input['end_date']) ? Carbon::parse($input['end_date']) : null;

        if ($end && $start->gt($end)) {
            return back()->with('error', 'Task cannot end before starting');
        }

        $input = array_add($input, 'project_id', $task->project->id);


        $task->update([
            'title' => $input ['title'],
            'description' => $input ['description'],
            'start_date' => $input ['start_date'],
            'end_date' => $input ['end_date'],
            'user_id' => $input ['user_id'],
            'task_priority_id' => $input ['task_priority_id'],
            'task_status_id' => $input ['task_status_id'],
            'project_id' => $input ['project_id'],
        ]);

        $task->fresh();

        $this->link($input);

        $this->sendAssignMail($input['user_id'], $task->id);

        return back()->with('success', 'Task updated successfully!');
    }


    public function destroy($task_id)
    {

    }

    public function sendAssignMail($user_id, $task_id)
    {
        $user = User::findOrFail($user_id);

        $task = Task::findOrFail($task_id);

        Mail::to($user->email)
            ->cc('admin@task-manager.com')
            ->bcc($task->project->projectLead->email)
            ->queue(new TaskAssigned($task));
    }

    private function link($input)
    {
        $projectMember = new ProjectMember();
        $projectMember->user_id = $input['user_id'];
        $projectMember->project_id = $input['project_id'];
        $projectMember->save();
    }
}

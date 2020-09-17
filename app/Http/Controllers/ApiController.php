<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getProjectTasks($project_id)
    {
        $tasks = Task::where('project_id', $project_id)->get();

        return response()->json(['tasks' => $tasks], 200);
    }
}

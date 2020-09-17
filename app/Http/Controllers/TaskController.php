<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {

    }


    public function create()
    {
        $users = User::all();

        
    }

    public function store(Request $request)
    {

    }

    public function show($project_id)
    {

    }

    public function edit($project_id)
    {

    }

    public function update(Request $request, $project_id)
    {

    }


    public function destroy($project_id)
    {

    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\RoleAssigned;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $this->adminCheck();

        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        $this->adminCheck();

        return view('users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $user = User::findOrFail($id);

        $user->update($request->all());

        return redirect('/users')->with('type', 'success')->with('message', 'User details updated!');
    }

    public function destroy($id)
    {
        //
    }

    public function makeUser($userId)
    {
        $this->adminCheck();

        $user = User::findOrFail($userId);

        $user->update(['role_id' => 1]);

        $this->sendRoleMail($userId);

        return redirect('/users')->with('type', 'success')->with('message', 'User is now Admin!');
    }

    public function makeAdmin($userId)
    {
        $this->adminCheck();

        $user = User::findOrFail($userId);

        $user->update(['role_id' => 2]);

        $this->sendRoleMail($userId);

        return redirect('/users')->with('type', 'success')->with('message', 'User privileges revoked!');
    }

    /**
     * @param $userId
     */
    protected function sendRoleMail($userId): void
    {
        $user = User::findOrFail($userId);

        Mail::to($user->email)
            ->cc('admin@task-manager.com')
            ->queue(new RoleAssigned($user));
    }

    private function adminCheck()
    {
        $user = auth()->user();

        if ($user->role->slug != 'admin') {
            return redirect('/')->with('type', 'danger')->with('message', 'Access Denied');
        }
    }
}

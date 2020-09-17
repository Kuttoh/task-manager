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
//        $this->middleware('auth');
    }


    public function index()
    {
        $user = auth()->user();

        if ($user->role->slug != 'admin') {
            return redirect('home')->with('error', 'Access Denied');
        }

        $users = User::with('role')->paginate(10);

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
        $user = auth()->user();

        if ($user->role->slug != 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }

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

        return redirect('/users')->with('success', 'User details updated!');
    }

    public function destroy($id)
    {
        //
    }

    public function makeUser($userId)
    {
        $user = auth()->user();

        if ($user->role->slug != 'admin') {
            return redirect('/')->with('error', 'Access Denied');
        }

        $user = User::findOrFail($userId);

        $user->update(['role_id' => 1]);

        $this->sendRoleMail($userId);

        return redirect('/users')->with('success', 'User is now Admin!');
    }

    public function makeAdmin($userId)
    {
        $this->adminCheck();

        $user = User::findOrFail($userId);

        $user->update(['role_id' => 2]);

        $this->sendRoleMail($userId);

        return redirect('/users')->with('warning', 'User privileges revoked!');
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

//    public function adminCheck()
//    {
//        $user = auth()->user();
//
//        if ($user->role->slug != 'admin') {
//            return redirect('/')->with('type', 'danger')->with('message', 'Access Denied');
//        }
//    }
}

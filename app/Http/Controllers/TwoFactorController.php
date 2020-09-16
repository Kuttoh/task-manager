<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    // show the two factor auth form
    public function show2faForm()
    {
        return view('auth.2fa');
    }
// post token to the backend for check
    public function verifyToken(Request $request)
    {
        $this->validate(['token' => 'required']);

        $user = auth()->user();

        if ($request->token == $user->two_factor_token) {
            $user->two_factor_expiry = \Carbon\Carbon::now()->addMinutes(config(session.lifetime));
            $user->save();
            return redirect()->intended('/home');
        }

        return redirect('/2fa')->with('message', 'Incorrect token.');
    }
}

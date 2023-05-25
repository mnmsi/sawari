<?php

namespace App\Http\Controllers\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends \Laravel\Nova\Http\Controllers\LoginController
{
    public function loginPage(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('nova.pages.dashboard');
        }
        return view("nova.login");
    }

    public function loginCheck(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'user_identity' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->user_identity;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $fieldType => $login,
            'password' => $request->password,
            'role_id' => 1,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('nova.pages.dashboard');
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Invalid credentials.',
        ]);
    }
}

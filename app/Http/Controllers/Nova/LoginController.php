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
        $request->merge([
           'phone' =>  $request->country_code . $request->phone
        ]);
        $request->validate([
            'email' => 'nullable|email|exists:App\Models\User\User,email',
            'phone' => 'nullable|string|exists:App\Models\User\User,phone',
            'password' => 'required',
        ]);

//        $login = $request->email ?? $request->phone;
////        dd($login);
//        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
//        dd($fieldType);


        $credentials = [
            'phone' => $request->phone,
            'password' => $request->password,
            'role_id' => [1, 3],
        ];

//        dd($credentials);

        if (Auth::attempt($credentials)) {
            return redirect()->route('nova.pages.dashboard');
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Invalid credentials.',
        ]);
    }
}

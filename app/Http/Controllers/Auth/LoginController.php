<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function validateLogin()
    {
        $this->validate(request(), [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], true);
    }

    protected function authenticated()
    {
        activity()->by(auth()->user())->log('Logged In');
        request()->session()->flash('flash', ['success', 'Logged in!']);

        return response()->json(['redirect' => route('index')]);
    }

    public function logout()
    {
        activity()->by(auth()->user())->log('Logged Out');

        $this->guard()->logout();
        request()->session()->invalidate();

        return redirect('/');
    }
}

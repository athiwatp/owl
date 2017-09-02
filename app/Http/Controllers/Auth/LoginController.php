<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated()
    {
        request()->session()->flash('flash', ['success', 'Logged in!']);

        return response()->json(['redirect' => route('index')]);
    }
}

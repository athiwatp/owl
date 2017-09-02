<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'timezone' => $data['timezone'],
        ]);
    }

    protected function registered()
    {
        activity()->by(auth()->user())->withProperties(request()->except(['_token', 'password', 'password_confirmation', 'g-recaptcha-response']))->log('Registered Account');
        request()->session()->flash('flash', ['success', 'Account registered!']);

        return response()->json(['redirect' => route('index')]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function register()
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);

        request()->merge(['password' => bcrypt(request()->input('password'))]);

        $user = User::create(request()->all());

        event(new Registered($user));
        $this->guard()->login($user);

        activity()->by(auth()->user())->withProperties(request()->except(['_token', 'password', 'password_confirmation', 'g-recaptcha-response']))->log('Registered Account');
        request()->session()->flash('flash', ['success', 'Account registered!']);

        return response()->json(['redirect' => route('index')]);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function reset()
    {
        $this->validate(request(), $this->rules());

        $response = $this->broker()->reset($this->credentials(request()), function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        if ($response == Password::PASSWORD_RESET) {
            activity()->by(auth()->user())->log('Reset Password');
            request()->session()->flash('flash', ['success', 'Password reset!']);

            return response()->json(['redirect' => route('index')]);
        }
        else {
            return response()->json(['errors' => ['email' => [trans($response)]]], 422);
        }
    }
}
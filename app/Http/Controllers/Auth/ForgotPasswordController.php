<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail()
    {
        $this->validateEmail(request());

        $response = $this->broker()->sendResetLink(request()->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            request()->session()->flash('flash', ['success', 'Password reset link sent!']);

            return response()->json(['redirect' => route('password.request')]);
        }
        else {
            return response()->json(['errors' => ['email' => [trans($response)]]], 422);
        }
    }
}
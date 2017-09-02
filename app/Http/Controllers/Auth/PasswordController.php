<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function updateForm()
    {
        return view('auth.password');
    }

    public function update()
    {
        $this->validate(request(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (Hash::check(request()->input('current_password'), auth()->user()->password)) {
            auth()->user()->update(['password' => bcrypt(request()->input('password'))]);
            activity()->by(auth()->user())->log('Updated Password');
            request()->session()->flash('flash', ['success', 'Password updated!']);

            return response()->json(['redirect' => route('password')]);
        }
        else {
            return response()->json(['errors' => ['current_password' => [trans('auth.failed')]]], 422);
        }
    }
}
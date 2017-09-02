<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function updateForm()
    {
        return view('auth.profile');
    }

    public function update()
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->user()->id,
            'timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
        ]);

        auth()->user()->update(request()->all());
        activity()->by(auth()->user())->withProperties(request()->except('_token'))->log('Updated Profile');
        request()->session()->flash('flash', ['success', 'Profile updated!']);

        return response()->json(['redirect' => route('profile')]);
    }
}
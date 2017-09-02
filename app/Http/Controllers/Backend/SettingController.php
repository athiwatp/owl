<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    public function updateForm()
    {
        return view('backend.settings');
    }

    public function update()
    {
        $this->validate(request(), [
            'title' => 'required',
            'default_timezone' => 'required|in:'.implode(',', timezone_identifiers_list()),
        ]);

        foreach (request()->except('_token') as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            $setting->update(['value' => $value]);
        }

        activity()->by(auth()->user())->withProperties(request()->except('_token'))->log('Updated Settings');
        request()->session()->flash('flash', ['success', 'Settings updated!']);

        return response()->json(['redirect' => route('settings')]);
    }
}
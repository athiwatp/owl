<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        if (config('owl.allow.frontend')) {
            return app()->call('App\Http\Controllers\Frontend\HomeController@index');
        }
        else if (auth()->guest()) {
            return redirect()->route('login');
        }
        else {
            return redirect()->route('dashboard');
        }
    }
}

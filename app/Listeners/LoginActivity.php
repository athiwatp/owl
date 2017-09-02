<?php

namespace App\Listeners;

class LoginActivity
{
    public function handle()
    {
        activity()->by(auth()->user())->log('Logged In');
    }
}
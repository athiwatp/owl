<?php

namespace App\Listeners;

class LogoutActivity
{
    public function handle()
    {
        activity()->by(auth()->user())->log('Logged Out');
    }
}
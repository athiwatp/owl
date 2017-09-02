<?php

namespace App;

use App\Traits\Owl;
use Illuminate\Mail\Message;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, Owl;

    protected $fillable = ['name', 'email', 'password', 'timezone'];
    protected $hidden = ['password', 'remember_token'];

    public function sendPasswordResetNotification($token)
    {
        Mail::send(['text' => 'emails.password'], ['token' => $token], function (Message $message) {
            $message->subject(config('settings.title').' Password Reset Link');
            $message->to($this->email);
        });
    }
}

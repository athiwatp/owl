<?php

namespace App\Http\Controllers;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function sendForm()
    {
        return view('contact');
    }

    public function send()
    {
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'enquiry' => 'required',
            'g-recaptcha-response' => 'sometimes|recaptcha',
        ]);

        Mail::send(['text' => 'emails.contact'], request()->all(), function (Message $message) {
            $message->subject(config('settings.title').' Contact');
            $message->to(config('mail.from.address'));
            $message->replyTo(request()->input('email'));
        });

        request()->session()->flash('flash', ['success', 'Message sent!']);

        return response()->json(['redirect' => route('contact')]);
    }
}
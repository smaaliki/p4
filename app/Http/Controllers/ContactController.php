<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Notifications\InboxMessage;
use App\Http\Requests\ContactFormRequest;
use App\Admin;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function mailToAdmin(ContactFormRequest $message, Admin $admin)
    {        //send the admin an notification
        $admin->notify(new InboxMessage($message));
        // redirect the user back
        //return view('contact');
        return redirect()->back()->with('message', 'Thanks for the message! We will get back to you soon!');
    }
}

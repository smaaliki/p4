<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendEmail(Request $request)
    {
    dd('Hello');
/*        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'address' => $request->address,
            'state' => $request->state
        ];

        Mail::send('AltHr/Portal/welcome', $data, function ($message) use ($request) {
            $message->from($request->email, $request->name);

            $message->to('smaaliki@hotmail.com')->subject('New Contact Center Account');
        });
*/
        return view('/contact');/*->with([
            'alert' => 'Your email has been sent successfully'
        ]);*/
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'subject' => [
                'required',
                'string',
                'max:200',
            ],

            'message' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        ContactMessage::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => ContactMessage::STATUS_NEW,
        ]);

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Thanks for reaching out! We have received your message and will get back to you soon.'
            );
    }
}
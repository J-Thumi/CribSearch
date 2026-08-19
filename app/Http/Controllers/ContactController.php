<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the contact us page.
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission.
     */
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

        // TODO: Send email / save message
        // Mail::to('support@cribsearch.co.ke')->send(...);

        return redirect()
            ->route('contact')
            ->with(
                'success',
                'Thanks for reaching out! We have received your message and will get back to you soon.'
            );
    }
}
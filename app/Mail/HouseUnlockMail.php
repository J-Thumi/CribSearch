<?php

namespace App\Mail;

use App\Models\House;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HouseUnlockMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public House $house,
        public string $navigationUrl,
        public string $caretakerPhone,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your CribSearch House Details Are Ready',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.house-unlock',
        );
    }
}
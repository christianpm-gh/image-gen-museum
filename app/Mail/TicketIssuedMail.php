<?php

namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class TicketIssuedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Ticket $ticket,
        public string $plainToken,
        public ?string $rootUrl = null,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu acceso a MusIAum ya está listo',
        );
    }

    public function content(): Content
    {
        if ($this->rootUrl !== null) {
            URL::useOrigin($this->rootUrl);
        }

        $accessUrl = URL::temporarySignedRoute(
            'memories.create',
            now()->addHours((int) config('museum.ticket_link_ttl_hours', 168)),
            [
                'ticket' => $this->ticket,
                'token' => $this->plainToken,
            ],
        );

        if ($this->rootUrl !== null) {
            URL::useOrigin(null);
        }

        return new Content(
            view: 'mail.tickets.issued',
            with: [
                'accessUrl' => $accessUrl,
            ],
        );
    }
}

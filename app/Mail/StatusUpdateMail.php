<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $supportTicketStatus;
    public $stuff_comment;
    public $supportTicketID;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($supportTicketStatus, $stuff_comment, $supportTicketID)
    {
        $this->supportTicketStatus = $supportTicketStatus;
        $this->stuff_comment = $stuff_comment;
        $this->supportTicketID = $supportTicketID;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Онлайн-заявка при технических ошибках',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'email.statusUpdate',
            with: [
                'supportTicketStatus' => $this->supportTicketStatus,
                'stuff_comment' => $this->stuff_comment,
                'supportTicketID' => $this->supportTicketID,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}

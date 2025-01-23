<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $from_email;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @param string $from_email
     * @param string $subject
     * @param string $message
     * @return void
     */
    public function __construct($from_email, $subject, $message)
    {
        $this->from_email = $from_email;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice', // Reference the view that will display the content
            with: [
                'message' => $this->message,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // If you have attachments, you can return them here.
        // Example: return [new \Illuminate\Mail\Mailables\Attachment(storage_path('path/to/invoice.pdf'))];
        return [];
    }
}

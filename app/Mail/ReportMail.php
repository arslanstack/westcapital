<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdfPath;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath; // Store the path of the PDF
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Report Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.report', // You can define the HTML email template here
            // Add any data you want to pass to the email view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            // Use the attach method to add the PDF attachment
            \Illuminate\Mail\Attachment::fromPath($this->pdfPath)->as('report.pdf')
        ];
    }
}

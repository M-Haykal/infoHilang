<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LaporanHilangMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $report;
    public $type;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct($report, $type, $user)
    {
        $this->report = $report;
        $this->type = $type;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = 'Konfirmasi Laporan ' . ucfirst($this->type) . ' Hilang - #' . $this->report->id;
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.laporan_hilang',
            with: [
                'report' => $this->report,
                'type' => $this->type,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

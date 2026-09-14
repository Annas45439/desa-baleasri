<?php

namespace App\Mail;

use App\Models\Complaint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminComplaintNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Complaint $complaint)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pengaduan Baru - ' . $this->complaint->kategori,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin-complaint-notification',
        );
    }
}

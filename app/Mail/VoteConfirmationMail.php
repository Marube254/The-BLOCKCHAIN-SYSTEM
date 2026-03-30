<?php

namespace App\Mail;

use App\Models\Voter;
use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VoteConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $voter;
    public $votes;

    public function __construct(Voter $voter, $votes)
    {
        $this->voter = $voter;
        $this->votes = $votes;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'IUEA Vote Confirmation - Your Vote Has Been Recorded',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.vote-confirmation',
        );
    }
}

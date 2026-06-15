<?php

namespace App\Mail;

use App\Models\PartRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartRequestReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PartRequest $partRequest) {}

    public function build(): self
    {
        return $this->subject('We received your Parts2Kenya request')
            ->view('emails.part-request-received');
    }
}

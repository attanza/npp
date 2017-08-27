<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Dream;

class BoostMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $dream;
    public $subject;

    public function __construct(Dream $dream, $subject)
    {
        $this->dream = $dream;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->subject($this->subject.' di Negeri Para Pemimpi')
            ->view('mails.boost_mail');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\DreamComment;

class DreamCommentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $comment;
    public $subject;

    public function __construct(DreamComment $comment, $subject)
    {
        $this->comment = $comment;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->subject($this->subject.' di Negeri Para Pemimpi')
            ->view('mails.dream_comment');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\DreamComment;

class DreamCommentNots extends Notification implements ShouldQueue
{
    use Queueable;

    public $comment;
    public $index;

    public function __construct(DreamComment $comment, $index)
    {
        $this->comment = $comment;
        $this->index = $index;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject('Tanggapan mimpi')
            ->view('mails.dream_comment', ['comment' => $this->comment]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'comment_id' => $this->comment->id,
            'type' => 'DreamComment',
            'msg' => 'Tanggapan mimpi'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'comment' => $this->comment,
            'index' => $this->index
        ]);
    }
}

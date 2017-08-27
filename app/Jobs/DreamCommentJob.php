<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Models\DreamComment;
use App\Models\Dream;
use App\Models\Notification;
use App\Events\NewCommentEvent;
use Mail;
use App\Mail\DreamCommentMail;

class DreamCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    public $parent_id;
    public $users;
    public $commentOwner;
    public $dreamOwner;
    public $index;

    public function __construct(DreamComment $comment, $index)
    {
        $this->comment = $comment;
        $this->parent_id = $comment->parent_id;
        $this->users = [];
        $this->commentOwner = $comment->owner;
        $this->dreamOwner = $comment->dream->user;
        $this->index = $index;
    }

    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | To Database
        |--------------------------------------------------------------------------
        */
        // if not Dream Owner on root comment
        if ($this->commentOwner != $this->dreamOwner && $this->parent_id == 0) {
            // Others on root Comment
            array_push($this->users, $this->dreamOwner);
            $subject = $this->getFulname($this->commentOwner).' menanggapi mimpimu';
            $this->saveNotification($subject);
            $this->sendMail($this->users, $this->comment, $subject);
        } elseif ($this->commentOwner != $this->dreamOwner && $this->parent_id != 0) {
            // Others reply to child
            // to dream owner
            array_push($this->users, $this->dreamOwner);
            $subject = $this->getFulname($this->commentOwner).' menanggapi mimpimu';
            $this->saveNotification($subject);
            $this->sendMail($this->users, $this->comment, $subject);

            // to others
            $this->getUsers();
            $subject = $this->getFulname($this->commentOwner).' menanggapi mimpi '.$this->getFulname($this->dreamOwner);
            $this->saveNotification($subject);
            $this->sendMail($this->users, $this->comment, $subject);
        } elseif ($this->commentOwner == $this->dreamOwner && $this->parent_id != 0) {
            // Dream Owner reply to child
            $this->getUsers();
            $subject = $this->getFulname($this->dreamOwner).' membalas tanggapan mimpinya';
            $this->saveNotification($subject);
            $this->sendMail($this->users, $this->comment, $subject);
        }

        /*
        |--------------------------------------------------------------------------
        | To Broadcast
        |--------------------------------------------------------------------------
        */
        event(new NewCommentEvent($this->comment, $this->index));
    }

    private function getUsers()
    {
        // empty users
        $this->users = [];
        $comment_data = $this->comment;
        $userData = [];
        $dream = Dream::with('comments')->find($comment_data->dream_id);
        // get all comment users except comment owner
        foreach ($dream->comments as $comment) {
            if ($comment->owner->id != $comment_data->owner->id && $comment->owner->id != $dream->user->id) {
                array_push($userData, $comment->owner);
            }
        }
        $this->users = collect(array_unique($userData));
    }

    private function saveNotification($subject)
    {
        $users = $this->users;
        if (count($users) > 0) {
            foreach ($users as $user) {
                $data = [
                  'msg' => $subject
                ];
                Notification::create([
                    'user_id' => $user->id,
                    'notifiable_id' => $this->comment->id,
                    'notifiable_type' => 'App\Models\DreamComment',
                    'data' => json_encode($data)
                ]);
            }
        }
    }

    private function getFulname($user)
    {
        return $user->first_name.' '.$user->last_name;
    }

    private function sendMail($users, $comment, $subject)
    {
        Mail::to($users)->send(new DreamCommentMail($comment, $subject));
    }
}

/*
|--------------------------------------------------------------------------
| Notifications
|--------------------------------------------------------------------------
1. Dream Owner on root comment
    -> No notification
2. Others on root Comment
    -> Notification to Dream owner
        ->Subject: others menanggapi mimpimu
3. Dream Owner on Child comment
    -> Notification to all comment->users except Dream Owner
        ->Subject:
            ->to Others: Dream Owner membalas tanggapan mimpinya
4. Others on Child Comment
    -> Notification to all comment->users except self
        ->Subject:
            ->to Dream Owner: comment owner menanggapi mimpmu
            ->to others: comment owner menanggapi mimpi Dream Owner
*/

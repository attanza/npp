<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Models\DreamComment;
use App\Models\Dream;
use App\Notifications\DreamCommentNots;

class DreamCommentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    public $index;

    public function __construct(DreamComment $comment, $index)
    {
        $this->comment = $comment;
        $this->index = $index;
    }

    public function handle()
    {
        $comment_data = $this->comment;
        // Log::info($comment_data);
        $dream = Dream::with('comments')->find($comment_data->dream_id);
        $users = [];
        if ($comment_data->owner != $dream->user) {
            array_push($users, $dream->user);
        }
        foreach ($dream->comments as $comment) {
            if ($comment->owner != $comment_data->owner) {
                array_push($users, $comment->owner);
            }
        }
        $users = collect(array_unique($users));
        // Log::info($users);
        Notification::send($users, new DreamCommentNots($comment_data, $this->index));
    }
}

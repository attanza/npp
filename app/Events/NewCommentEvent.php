<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\DreamComment;
use App\Traits\CommentTrait;

class NewCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels, CommentTrait;

    public $comment;
    private $slug;
    public $owner_id;

    public function __construct(DreamComment $comment)
    {
        $this->comment = $this->getArrayData($comment);
        $this->slug = $comment->dream->slug;
        $this->owner_id = $comment->owner->id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('npp-dream.'.$this->slug);
    }
}

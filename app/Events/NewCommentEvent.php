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

class NewCommentEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $comment;
    public $index;
    private $slug;

    public function __construct(DreamComment $comment, $index)
    {
        $this->comment = $comment;
        $this->index = $index;
        $this->slug = $comment->dream->slug;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('npp-dream.'.$this->slug);
    }
}

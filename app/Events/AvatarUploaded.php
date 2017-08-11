<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AvatarUploaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $avatar;
    private $username;

    public function __construct($username, $avatar)
    {
        $this->avatar = $avatar;
        $this->username = $username;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('npp-user.'.$this->username);
    }
}

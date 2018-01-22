<?php

namespace App\Events;

use App\Rambutan\Album\ReadModel\ReadAlbum;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReadAlbumChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $album;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ReadAlbum $album)
    {
        $this->album = $album;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['test-channel'];//return new PrivateChannel('channel-name');
    }
}

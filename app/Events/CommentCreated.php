<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comentar;

class CommentCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Comentar $comment;

    /**
     * Create a new event instance.
     */
    public function __construct(Comentar $comment)
    {
        $this->comment = $comment->load('user', 'replies');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return new Channel(
            'comments.' .
            $this->comment->foundable_type. '.' .
            $this->comment->foundable_id
        )
    }

    public function broadcastAs(): string
    {
        return 'comment.created';
    }
}

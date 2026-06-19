<?php

namespace App\Events;

use App\Models\CustomerChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewCustomerChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public CustomerChatMessage $message;

    /**
     * Create a new event instance.
     */
    public function __construct(CustomerChatMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('chat.admin'),
        ];

        // Kirim ke channel privat user jika login
        if ($this->message->user_id) {
            $channels[] = new PrivateChannel('chat.user.' . $this->message->user_id);
        }

        // Kirim ke channel privat guest jika tidak login
        if (!$this->message->user_id && $this->message->session_id) {
            $channels[] = new PrivateChannel('chat.guest.' . $this->message->session_id);
        }

        return $channels;
    }

    /**
     * Nama event yang akan didengar oleh frontend.
     */
    public function broadcastAs(): string
    {
        return 'new-customer-chat-message';
    }

    /**
     * Data yang dikirim bersama event.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'user_id' => $this->message->user_id,
            'session_id' => $this->message->session_id,
            'message' => $this->message->message,
            'sender_type' => $this->message->sender_type,
            'is_read' => $this->message->is_read,
            'created_at' => $this->message->created_at->toISOString(),
            'created_at_diff' => $this->message->created_at->diffForHumans(),
        ];
    }
}
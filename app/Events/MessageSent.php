<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
 public function __construct(public Message $message) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('consultations.' . $this->message->consultation_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id'              => $this->message->id,
            'body'            => $this->message->body,
            'sender_type'     => $this->message->sender_type,
            'user_id'         => $this->message->user_id,
            'consultation_id' => $this->message->consultation_id,
            'created_at'      => $this->message->created_at->toTimeString(),
            'updated_at'      => $this->message->updated_at->toTimeString(),

        ];
    }
}
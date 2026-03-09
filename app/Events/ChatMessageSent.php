<?php
namespace App\Events;
use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
class ChatMessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public function __construct(public ChatMessage $message) { $this->message->load('conversation'); }
    public function broadcastOn(): array { return [new Channel('chat.'.$this->message->conversation->uuid), new PrivateChannel('admin.chat')]; }
    public function broadcastAs(): string { return 'message.sent'; }
    public function broadcastWith(): array
    {
        return ['id' => $this->message->id, 'conversation_uuid' => $this->message->conversation->uuid, 'sender_type' => $this->message->sender_type, 'message' => $this->message->message, 'created_at' => $this->message->created_at?->toISOString()];
    }
}

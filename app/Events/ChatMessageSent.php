<?php
namespace App\Events;
use App\Models\ChatConversation; use App\Models\ChatMessage; use Illuminate\Broadcasting\Channel; use Illuminate\Broadcasting\InteractsWithSockets; use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
class ChatMessageSent implements ShouldBroadcast { use InteractsWithSockets; public function __construct(public ChatConversation $conversation, public ChatMessage $message) {} public function broadcastOn(): array { return [new Channel('chat.'.$this->conversation->uuid), new Channel('admin.dashboard')]; } public function broadcastAs(): string { return 'chat.message.sent'; } public function broadcastWith(): array { return ['conversation_uuid' => $this->conversation->uuid, 'message' => $this->message->toArray()]; } }

<?php
namespace App\Http\Controllers;
use App\Events\ChatMessageSent;
use App\Http\Requests\SendChatMessageRequest;
use App\Http\Requests\StartChatRequest;
use App\Models\ChatConversation;
class ChatController extends Controller {
    public function start(StartChatRequest $request) {
        $conversation = ChatConversation::create(['visitor_name' => $request->string('name')->toString(),'visitor_email' => $request->string('email')->toString(),'visitor_phone' => $request->string('phone')->toString(),'status' => 'open','source_url' => $request->string('source_url')->toString(),'meta' => ['ip' => $request->ip(),'user_agent' => $request->userAgent(),],]);
        if ($request->filled('message')) { $message = $conversation->messages()->create(['sender_type' => 'visitor','message' => $request->string('message')->toString(),'attachments' => [],'is_read' => false,]); broadcast(new ChatMessageSent($conversation, $message))->toOthers(); }
        return response()->json($conversation->load('messages'), 201);
    }
    public function show(ChatConversation $conversation) { return response()->json($conversation->load('messages')); }
    public function sendMessage(SendChatMessageRequest $request, ChatConversation $conversation) { $message = $conversation->messages()->create(['sender_type' => 'visitor','message' => $request->string('message')->toString(),'attachments' => [],'is_read' => false,]); broadcast(new ChatMessageSent($conversation, $message))->toOthers(); return response()->json($message, 201); }
}

<?php
namespace App\Http\Controllers;
use App\Events\ChatMessageSent;
use App\Models\ChatConversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class ChatController extends Controller
{
    public function startConversation(Request $request): JsonResponse
    {
        $data = $request->validate([
            'visitor_name' => ['nullable','string','max:255'],
            'visitor_email' => ['nullable','email','max:255'],
            'visitor_phone' => ['nullable','string','max:50'],
            'message' => ['required','string','max:5000'],
        ]);
        $conversation = ChatConversation::create([
            'visitor_name' => $data['visitor_name'] ?? null,
            'visitor_email' => $data['visitor_email'] ?? null,
            'visitor_phone' => $data['visitor_phone'] ?? null,
            'status' => 'open',
            'source' => 'site_widget',
            'last_message_at' => now(),
            'meta' => ['ip' => $request->ip(), 'user_agent' => $request->userAgent()],
        ]);
        $message = $conversation->messages()->create(['sender_type' => 'guest', 'message' => $data['message']]);
        broadcast(new ChatMessageSent($message))->toOthers();
        return response()->json(['ok' => true, 'conversation' => $conversation, 'message' => $message], 201);
    }
    public function messages(ChatConversation $conversation): JsonResponse
    {
        return response()->json($conversation->messages()->orderBy('id')->get());
    }
    public function sendGuestMessage(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate(['message' => ['required','string','max:5000']]);
        $message = $conversation->messages()->create(['sender_type' => 'guest', 'message' => $data['message']]);
        $conversation->update(['last_message_at' => now()]);
        broadcast(new ChatMessageSent($message))->toOthers();
        return response()->json(['ok' => true, 'message' => $message], 201);
    }
}

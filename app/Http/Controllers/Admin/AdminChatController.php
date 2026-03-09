<?php
namespace App\Http\Controllers\Admin;
use App\Events\ChatMessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class AdminChatController extends Controller
{
    public function index(): JsonResponse { return response()->json(ChatConversation::query()->latest('last_message_at')->paginate(30)); }
    public function messages(ChatConversation $conversation): JsonResponse { return response()->json($conversation->messages()->orderBy('id')->get()); }
    public function sendAdminMessage(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate(['message' => ['required','string','max:5000']]);
        $message = $conversation->messages()->create(['sender_type' => 'admin', 'sender_id' => $request->user()->id, 'message' => $data['message']]);
        $conversation->update(['assigned_to' => $request->user()->id, 'last_message_at' => now()]);
        broadcast(new ChatMessageSent($message))->toOthers();
        return response()->json(['ok' => true, 'message' => $message], 201);
    }
    public function update(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate(['status' => ['nullable','string','max:50'], 'assigned_to' => ['nullable','exists:users,id']]);
        $conversation->update($data);
        return response()->json(['ok' => true, 'conversation' => $conversation->fresh()]);
    }
}

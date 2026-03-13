<?php

namespace App\Http\Controllers\Admin;

use App\Events\ChatMessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatConversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminChatController extends Controller
{
    public function index(): JsonResponse
    {
        $items = ChatConversation::query()
            ->withCount([
                'unreadGuestMessages as unread_count',
                'messages as messages_count',
            ])
            ->with(['admin:id,name,email'])
            ->orderByRaw("CASE WHEN status = 'open' THEN 0 WHEN status = 'in_progress' THEN 1 ELSE 2 END")
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->get()
            ->map(function (ChatConversation $conversation) {
                $last = $conversation->messages()->latest('id')->first();

                return [
                    'id' => $conversation->id,
                    'uuid' => $conversation->uuid,
                    'visitor_name' => $conversation->visitor_name,
                    'visitor_email' => $conversation->visitor_email,
                    'visitor_phone' => $conversation->visitor_phone,
                    'status' => $conversation->status,
                    'last_message_at' => optional($conversation->last_message_at)?->toDateTimeString(),
                    'unread_count' => (int) ($conversation->unread_count ?? 0),
                    'messages_count' => (int) ($conversation->messages_count ?? 0),
                    'assigned_to' => $conversation->assigned_to,
                    'admin' => $conversation->admin,
                    'last_message' => $last?->message,
                    'last_sender_type' => $last?->sender_type,
                ];
            });

        return response()->json([
            'data' => $items,
        ]);
    }

    public function messages(ChatConversation $conversation): JsonResponse
    {
        $messages = $conversation->messages()
            ->with('sender:id,name,email')
            ->orderBy('id')
            ->get();

        $conversation->markGuestMessagesAsRead();

        return response()->json($messages);
    }

    public function sendAdminMessage(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_type' => 'admin',
            'sender_id' => Auth::id(),
            'message' => trim((string) $data['message']),
            'is_read' => true,
        ]);

        $conversation->update([
            'assigned_to' => Auth::id(),
            'status' => 'in_progress',
            'last_message_at' => now(),
        ]);

        $conversation->markGuestMessagesAsRead();

        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json([
            'ok' => true,
            'message' => $message->load('sender:id,name,email'),
        ], 201);
    }

    public function update(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:open,in_progress,closed'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $conversation->update($data);

        return response()->json([
            'ok' => true,
            'conversation' => $conversation->fresh(),
        ]);
    }
}
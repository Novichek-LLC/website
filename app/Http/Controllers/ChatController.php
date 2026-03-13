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
            'visitor_name' => ['nullable', 'string', 'max:255'],
            'visitor_email' => ['nullable', 'string', 'max:255'],
            'visitor_phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $email = isset($data['visitor_email']) ? trim((string) $data['visitor_email']) : null;

        if ($email !== null && $email !== '' && ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => [
                    'visitor_email' => ['Введите корректный email или оставьте поле пустым.'],
                ],
            ], 422);
        }

        $conversation = ChatConversation::create([
            'visitor_name' => isset($data['visitor_name']) ? trim((string) $data['visitor_name']) : null,
            'visitor_email' => $email ?: null,
            'visitor_phone' => isset($data['visitor_phone']) ? trim((string) $data['visitor_phone']) : null,
            'status' => 'open',
            'source' => 'site_widget',
            'last_message_at' => now(),
            'meta' => [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ],
        ]);

        $message = $conversation->messages()->create([
            'sender_type' => 'guest',
            'message' => trim((string) $data['message']),
            'is_read' => false,
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json([
            'ok' => true,
            'conversation' => $conversation,
            'message' => $message,
        ], 201);
    }

    public function messages(ChatConversation $conversation): JsonResponse
    {
        return response()->json(
            $conversation->messages()->with('sender:id,name,email')->orderBy('id')->get()
        );
    }

    public function sendGuestMessage(Request $request, ChatConversation $conversation): JsonResponse
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = $conversation->messages()->create([
            'sender_type' => 'guest',
            'message' => trim((string) $data['message']),
            'is_read' => false,
        ]);

        $conversation->update([
            'last_message_at' => now(),
            'status' => 'open',
        ]);

        broadcast(new ChatMessageSent($message))->toOthers();

        return response()->json([
            'ok' => true,
            'message' => $message,
        ], 201);
    }
}
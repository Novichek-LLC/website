<?php

namespace App\Http\Controllers;

use App\Models\ChatConversation;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index()
    {
        return ChatConversation::with('messages')->latest()->get();
    }

    public function start(Request $request)
    {
        $conversation = ChatConversation::create([
            'token' => Str::uuid(),
            'client_name' => $request->string('name'),
            'client_contact' => $request->string('contact'),
            'status' => 'new',
        ]);

        ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'role' => 'client',
            'body' => $request->string('body'),
        ]);

        return response()->json($conversation->load('messages'));
    }

    public function show(string $token)
    {
        return ChatConversation::where('token', $token)->with('messages')->firstOrFail();
    }

    public function message(Request $request, string $token)
    {
        $conversation = ChatConversation::where('token', $token)->firstOrFail();

        ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'role' => 'client',
            'body' => $request->string('body'),
        ]);

        return $conversation->fresh('messages');
    }

    public function reply(Request $request, ChatConversation $conversation)
    {
        ChatMessage::create([
            'chat_conversation_id' => $conversation->id,
            'role' => 'admin',
            'body' => $request->string('body'),
        ]);

        return $conversation->fresh('messages');
    }

    public function status(Request $request, ChatConversation $conversation)
    {
        $conversation->update([
            'status' => $request->string('status', 'active'),
        ]);

        return $conversation->fresh('messages');
    }
}

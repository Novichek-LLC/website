<?php
namespace App\Http\Controllers\Admin;
use App\Events\ChatMessageSent; use App\Http\Controllers\Controller; use App\Http\Requests\Admin\StoreAdminChatMessageRequest; use App\Models\ChatConversation;
class AdminChatController extends Controller {
  public function index() { return response()->json(ChatConversation::withCount('messages')->latest()->paginate(20)); }
  public function show(ChatConversation $conversation) { return response()->json($conversation->load('messages')); }
  public function storeMessage(StoreAdminChatMessageRequest $request, ChatConversation $conversation) { $message = $conversation->messages()->create(['sender_type' => 'admin','sender_id' => $request->user()->id,'message' => $request->string('message')->toString(),'attachments' => [],'is_read' => true,]); broadcast(new ChatMessageSent($conversation, $message))->toOthers(); return response()->json($message, 201); }
}

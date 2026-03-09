<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ChatMessage extends Model {
    protected $fillable = ['conversation_id','sender_type','sender_id','message','attachments','is_read'];
    protected $casts = ['attachments' => 'array', 'is_read' => 'boolean'];
    public function conversation(): BelongsTo { return $this->belongsTo(ChatConversation::class, 'conversation_id'); }
}

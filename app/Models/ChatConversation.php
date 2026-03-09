<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class ChatConversation extends Model {
    protected $fillable = ['uuid','visitor_name','visitor_email','visitor_phone','status','source_url','meta','assigned_to'];
    protected $casts = ['meta' => 'array'];
    protected static function booted(): void { static::creating(function (self $conversation) { $conversation->uuid ??= (string) Str::uuid(); }); }
    public function messages(): HasMany { return $this->hasMany(ChatMessage::class, 'conversation_id'); }
}

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class ChatConversation extends Model
{
    use HasFactory;
    protected $fillable = ['uuid','visitor_name','visitor_email','visitor_phone','source','status','last_message_at','assigned_to','meta'];
    protected $casts = ['last_message_at' => 'datetime', 'meta' => 'array'];
    protected static function booted(): void
    {
        static::creating(function (self $conversation) {
            if (!$conversation->uuid) $conversation->uuid = (string) Str::uuid();
        });
    }
    public function getRouteKeyName(): string { return 'uuid'; }
    public function messages(): HasMany { return $this->hasMany(ChatMessage::class, 'conversation_id'); }
}

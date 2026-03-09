<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatConversation extends Model
{
    protected $fillable = [
        'token',
        'client_name',
        'client_contact',
        'status',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->latest('id');
    }
}

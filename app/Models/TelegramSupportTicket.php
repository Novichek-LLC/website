<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramSupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'telegram_user_id',
        'telegram_chat_id',
        'telegram_username',
        'first_name',
        'last_name',
        'subject',
        'message',
        'status',
    ];
}
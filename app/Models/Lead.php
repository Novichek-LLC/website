<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'service',
        'name',
        'company',
        'email',
        'phone',
        'telegram',
        'message',
        'source',
        'status',
        'budget',
        'priority',
        'assigned_to',
        'last_comment',
        'meta',
    ];

    protected $casts = [
        'status' => LeadStatus::class,
        'meta' => 'array',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
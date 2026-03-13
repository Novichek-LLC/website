<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'badge_label',
        'visual_theme',
        'cover_path',
        'is_published',
        'published_at',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'author_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'cover_url',
    ];

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_path) {
            return null;
        }

        return Storage::disk('public')->url($this->cover_path);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\BlogComment::class)->latest();
    }

    public function approvedComments()
    {
        return $this->hasMany(\App\Models\BlogComment::class)->where('status', 'approved');
    }

    public function reactions()
    {
        return $this->hasMany(\App\Models\BlogReaction::class);
    }
}
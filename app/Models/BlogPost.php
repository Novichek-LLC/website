<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','excerpt','content','cover_path','is_published','published_at','seo_title','seo_description','seo_keywords','author_id'];
    protected $casts = ['is_published' => 'boolean', 'published_at' => 'datetime'];
    protected $appends = ['cover_url'];
    public function getCoverUrlAttribute(): ?string { return $this->cover_path ? asset('storage/'.$this->cover_path) : null; }
}

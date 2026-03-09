<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class CaseItem extends Model
{
    use HasFactory;
    protected $table = 'cases';
    protected $fillable = ['title','slug','service','client_name','summary','content','result_metrics','cover_path','is_published','published_at','seo_title','seo_description','seo_keywords'];
    protected $casts = ['result_metrics' => 'array', 'is_published' => 'boolean', 'published_at' => 'datetime'];
    protected $appends = ['cover_url'];
    public function getCoverUrlAttribute(): ?string { return $this->cover_path ? asset('storage/'.$this->cover_path) : null; }
}

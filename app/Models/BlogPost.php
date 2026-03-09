<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class BlogPost extends Model {
    protected $fillable = ['title','slug','excerpt','content','cover_path','status','seo_title','seo_description','seo_keywords','published_at','author_id'];
    protected $casts = ['published_at' => 'datetime'];
}

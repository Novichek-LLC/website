<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CaseStudy extends Model {
    protected $fillable = ['title','slug','client_name','service','industry','summary','challenge','solution','result','cover_path','gallery','status','seo_title','seo_description'];
    protected $casts = ['gallery' => 'array'];
}

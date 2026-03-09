<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
    protected $fillable = ['name','phone','email','company','service','source','message','budget','status','pipeline_stage','assigned_to','meta'];
    protected $casts = ['meta' => 'array'];
}

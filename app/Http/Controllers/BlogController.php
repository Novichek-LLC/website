<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;
class BlogController extends Controller { public function index() { return response()->json(BlogPost::query()->where('status','published')->orderByDesc('published_at')->get()); } public function show(string $slug) { return response()->json(BlogPost::query()->where('slug',$slug)->where('status','published')->firstOrFail()); } }

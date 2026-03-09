<?php
namespace App\Http\Controllers;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
class BlogController extends Controller
{
    public function index(): JsonResponse { return response()->json(BlogPost::query()->where('is_published', true)->latest('published_at')->get()); }
    public function show(string $slug): JsonResponse { return response()->json(BlogPost::query()->where('slug', $slug)->where('is_published', true)->firstOrFail()); }
}

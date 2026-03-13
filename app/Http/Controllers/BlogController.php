<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;

class BlogController extends Controller
{
    public function index(): JsonResponse
    {
        $items = BlogPost::query()
            ->where('is_published', true)
            ->with(['reactions:id,blog_post_id,reaction_key'])
            ->withCount(['approvedComments as approved_comments_count'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (BlogPost $post) => $this->formatPost($post));

        return response()->json($items);
    }

    public function show(string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->with(['reactions:id,blog_post_id,reaction_key'])
            ->withCount(['approvedComments as approved_comments_count'])
            ->firstOrFail();

        return response()->json($this->formatPost($post));
    }

    protected function formatPost(BlogPost $post): array
    {
        $summary = [
            'like' => 0,
            'fire' => 0,
            'idea' => 0,
            'rocket' => 0,
        ];

        foreach ($post->reactions as $reaction) {
            if (isset($summary[$reaction->reaction_key])) {
                $summary[$reaction->reaction_key]++;
            }
        }

        return array_merge($post->toArray(), [
            'reactions_summary' => $summary,
            'approved_comments_count' => (int) ($post->approved_comments_count ?? 0),
        ]);
    }
}
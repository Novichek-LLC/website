<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogReaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogReactionController extends Controller
{
    protected array $allowed = ['like', 'fire', 'idea', 'rocket'];

    public function index(Request $request, string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $visitorToken = (string) $request->query('visitor_token', '');

        return response()->json([
            'summary' => $this->buildSummary($post->id),
            'my_reactions' => $visitorToken
                ? BlogReaction::query()
                    ->where('blog_post_id', $post->id)
                    ->where('visitor_token', $visitorToken)
                    ->pluck('reaction_key')
                    ->values()
                : [],
        ]);
    }

    public function toggle(Request $request, string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $data = $request->validate([
            'reaction_key' => ['required', 'in:like,fire,idea,rocket'],
            'visitor_token' => ['required', 'string', 'max:100'],
        ]);

        $existing = BlogReaction::query()
            ->where('blog_post_id', $post->id)
            ->where('reaction_key', $data['reaction_key'])
            ->where('visitor_token', $data['visitor_token'])
            ->first();

        $active = false;

        if ($existing) {
            $existing->delete();
        } else {
            BlogReaction::create([
                'blog_post_id' => $post->id,
                'reaction_key' => $data['reaction_key'],
                'visitor_token' => $data['visitor_token'],
                'ip_address' => $request->ip(),
            ]);

            $active = true;
        }

        return response()->json([
            'ok' => true,
            'active' => $active,
            'summary' => $this->buildSummary($post->id),
            'my_reactions' => BlogReaction::query()
                ->where('blog_post_id', $post->id)
                ->where('visitor_token', $data['visitor_token'])
                ->pluck('reaction_key')
                ->values(),
        ]);
    }

    protected function buildSummary(int $postId): array
    {
        $base = [
            'like' => 0,
            'fire' => 0,
            'idea' => 0,
            'rocket' => 0,
        ];

        $counts = BlogReaction::query()
            ->selectRaw('reaction_key, COUNT(*) as aggregate')
            ->where('blog_post_id', $postId)
            ->groupBy('reaction_key')
            ->pluck('aggregate', 'reaction_key')
            ->toArray();

        foreach ($counts as $key => $count) {
            if (array_key_exists($key, $base)) {
                $base[$key] = (int) $count;
            }
        }

        return $base;
    }
}
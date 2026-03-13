<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function index(string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $comments = $post->comments()
            ->where('status', 'approved')
            ->get([
                'id',
                'author_name',
                'content',
                'created_at',
            ]);

        return response()->json($comments);
    }

    public function store(Request $request, string $slug): JsonResponse
    {
        $post = BlogPost::query()
            ->where('is_published', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:120'],
            'author_email' => ['nullable', 'email', 'max:190'],
            'content' => ['required', 'string', 'min:3', 'max:3000'],
        ]);

        $comment = BlogComment::create([
            'blog_post_id' => $post->id,
            'author_name' => trim($data['author_name']),
            'author_email' => isset($data['author_email']) ? trim($data['author_email']) : null,
            'content' => trim($data['content']),
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Комментарий отправлен и ожидает модерации.',
            'comment_id' => $comment->id,
        ], 201);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeArticle;
use App\Models\KnowledgeCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KnowledgeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->get('search'));

        $articles = KnowledgeArticle::query()
            ->with('category:id,name,slug')
            ->where('is_published', true)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('excerpt', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(12);

        $featured = KnowledgeArticle::query()
            ->with('category:id,name,slug')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->latest('published_at')
            ->take(6)
            ->get();

        $categories = KnowledgeCategory::query()
            ->where('is_active', true)
            ->withCount([
                'articles' => fn ($q) => $q->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json([
            'articles' => $articles,
            'featured' => $featured,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $article = KnowledgeArticle::query()
            ->with('category:id,name,slug,description')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $related = KnowledgeArticle::query()
            ->with('category:id,name,slug')
            ->where('knowledge_category_id', $article->knowledge_category_id)
            ->where('id', '!=', $article->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->take(4)
            ->get();

        return response()->json([
            'article' => $article,
            'related' => $related,
        ]);
    }

    public function categories(): JsonResponse
    {
        $categories = KnowledgeCategory::query()
            ->where('is_active', true)
            ->withCount([
                'articles' => fn ($q) => $q->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return response()->json($categories);
    }

    public function category(string $slug): JsonResponse
    {
        $category = KnowledgeCategory::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $articles = KnowledgeArticle::query()
            ->with('category:id,name,slug')
            ->where('knowledge_category_id', $category->id)
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12);

        return response()->json([
            'category' => $category,
            'articles' => $articles,
        ]);
    }
}
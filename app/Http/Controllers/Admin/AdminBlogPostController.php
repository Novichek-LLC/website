<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AdminBlogPostController extends Controller
{
    public function index(): JsonResponse { return response()->json(BlogPost::query()->latest()->paginate(20)); }
    public function show(BlogPost $blogPost): JsonResponse { return response()->json($blogPost); }
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['title' => ['required','string','max:255'], 'excerpt' => ['nullable','string'], 'content' => ['required','string'], 'is_published' => ['boolean'], 'published_at' => ['nullable','date'], 'seo_title' => ['nullable','string','max:255'], 'seo_description' => ['nullable','string'], 'seo_keywords' => ['nullable','string','max:255']]);
        $post = BlogPost::create([...$data, 'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(5)), 'author_id' => $request->user()->id]);
        return response()->json($post, 201);
    }
    public function update(Request $request, BlogPost $blogPost): JsonResponse
    {
        $data = $request->validate(['title' => ['required','string','max:255'], 'excerpt' => ['nullable','string'], 'content' => ['required','string'], 'is_published' => ['boolean'], 'published_at' => ['nullable','date'], 'seo_title' => ['nullable','string','max:255'], 'seo_description' => ['nullable','string'], 'seo_keywords' => ['nullable','string','max:255']]);
        $blogPost->update($data);
        return response()->json($blogPost->fresh());
    }
    public function destroy(BlogPost $blogPost): JsonResponse { $blogPost->delete(); return response()->json(['ok' => true]); }
    public function uploadCover(Request $request, BlogPost $blogPost): JsonResponse
    {
        $request->validate(['cover' => ['required','image','max:5120']]);
        $path = $request->file('cover')->store('blog', 'public');
        $blogPost->update(['cover_path' => $path]);
        return response()->json(['ok' => true, 'cover_url' => asset('storage/'.$path)]);
    }
}

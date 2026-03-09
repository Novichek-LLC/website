<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\StoreBlogPostRequest; use App\Models\BlogPost; use Illuminate\Support\Facades\Storage;
class AdminBlogPostController extends Controller {
  public function index() { return response()->json(BlogPost::latest()->paginate(20)); }
  public function store(StoreBlogPostRequest $request) { $data = $request->validated(); if ($request->hasFile('cover')) { $data['cover_path'] = $request->file('cover')->store('blog/covers', 'public'); } return response()->json(BlogPost::create($data), 201); }
  public function show(BlogPost $blog) { return response()->json($blog); }
  public function update(StoreBlogPostRequest $request, BlogPost $blog) { $data = $request->validated(); if ($request->hasFile('cover')) { if ($blog->cover_path) { Storage::disk('public')->delete($blog->cover_path); } $data['cover_path'] = $request->file('cover')->store('blog/covers', 'public'); } $blog->update($data); return response()->json($blog->fresh()); }
  public function destroy(BlogPost $blog) { if ($blog->cover_path) { Storage::disk('public')->delete($blog->cover_path); } $blog->delete(); return response()->noContent(); }
}

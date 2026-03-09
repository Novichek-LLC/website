<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\CaseItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class AdminCaseController extends Controller
{
    public function index(): JsonResponse { return response()->json(CaseItem::query()->latest()->paginate(20)); }
    public function show(CaseItem $caseItem): JsonResponse { return response()->json($caseItem); }
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['title' => ['required','string','max:255'], 'service' => ['required','string','max:255'], 'client_name' => ['nullable','string','max:255'], 'summary' => ['nullable','string'], 'content' => ['required','string'], 'result_metrics' => ['nullable','array'], 'is_published' => ['boolean'], 'published_at' => ['nullable','date'], 'seo_title' => ['nullable','string','max:255'], 'seo_description' => ['nullable','string'], 'seo_keywords' => ['nullable','string','max:255']]);
        $case = CaseItem::create([...$data, 'slug' => Str::slug($data['title']).'-'.Str::lower(Str::random(5))]);
        return response()->json($case, 201);
    }
    public function update(Request $request, CaseItem $caseItem): JsonResponse
    {
        $data = $request->validate(['title' => ['required','string','max:255'], 'service' => ['required','string','max:255'], 'client_name' => ['nullable','string','max:255'], 'summary' => ['nullable','string'], 'content' => ['required','string'], 'result_metrics' => ['nullable','array'], 'is_published' => ['boolean'], 'published_at' => ['nullable','date'], 'seo_title' => ['nullable','string','max:255'], 'seo_description' => ['nullable','string'], 'seo_keywords' => ['nullable','string','max:255']]);
        $caseItem->update($data);
        return response()->json($caseItem->fresh());
    }
    public function destroy(CaseItem $caseItem): JsonResponse { $caseItem->delete(); return response()->json(['ok' => true]); }
    public function uploadCover(Request $request, CaseItem $caseItem): JsonResponse
    {
        $request->validate(['cover' => ['required','image','max:5120']]);
        $path = $request->file('cover')->store('cases', 'public');
        $caseItem->update(['cover_path' => $path]);
        return response()->json(['ok' => true, 'cover_url' => asset('storage/'.$path)]);
    }
}

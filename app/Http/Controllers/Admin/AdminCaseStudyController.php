<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\StoreCaseStudyRequest; use App\Models\CaseStudy; use Illuminate\Support\Facades\Storage;
class AdminCaseStudyController extends Controller {
  public function index() { return response()->json(CaseStudy::latest()->paginate(20)); }
  public function store(StoreCaseStudyRequest $request) { $data = $request->validated(); if ($request->hasFile('cover')) { $data['cover_path'] = $request->file('cover')->store('cases/covers', 'public'); } $data['gallery'] = $request->input('gallery', []); return response()->json(CaseStudy::create($data), 201); }
  public function show(CaseStudy $case) { return response()->json($case); }
  public function update(StoreCaseStudyRequest $request, CaseStudy $case) { $data = $request->validated(); if ($request->hasFile('cover')) { if ($case->cover_path) { Storage::disk('public')->delete($case->cover_path); } $data['cover_path'] = $request->file('cover')->store('cases/covers', 'public'); } $case->update($data); return response()->json($case->fresh()); }
  public function destroy(CaseStudy $case) { if ($case->cover_path) { Storage::disk('public')->delete($case->cover_path); } $case->delete(); return response()->noContent(); }
}

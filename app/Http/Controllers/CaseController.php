<?php
namespace App\Http\Controllers;
use App\Models\CaseItem;
use Illuminate\Http\JsonResponse;
class CaseController extends Controller
{
    public function index(): JsonResponse { return response()->json(CaseItem::query()->where('is_published', true)->latest('published_at')->get()); }
    public function show(string $slug): JsonResponse { return response()->json(CaseItem::query()->where('slug', $slug)->where('is_published', true)->firstOrFail()); }
}

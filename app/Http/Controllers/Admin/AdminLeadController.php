<?php
namespace App\Http\Controllers\Admin;
use App\Enums\LeadStatus;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;
class AdminLeadController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Lead::query()->latest();
        if ($request->filled('status')) $query->where('status', $request->string('status'));
        if ($request->filled('service')) $query->where('service', $request->string('service'));
        return response()->json($query->paginate(20));
    }
    public function update(Request $request, Lead $lead): JsonResponse
    {
        $data = $request->validate(['status' => ['nullable', new Enum(LeadStatus::class)], 'priority' => ['nullable','string','max:50'], 'assigned_to' => ['nullable','exists:users,id'], 'budget' => ['nullable','integer','min:0']]);
        $lead->update($data);
        return response()->json(['ok' => true, 'lead' => $lead->fresh()]);
    }
    public function comment(Request $request, Lead $lead): JsonResponse
    {
        $data = $request->validate(['comment' => ['required','string','max:5000']]);
        $lead->update(['last_comment' => $data['comment']]);
        return response()->json(['ok' => true]);
    }
}

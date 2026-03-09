<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Http\Requests\Admin\UpdateLeadRequest; use App\Models\Lead;
class AdminLeadController extends Controller { public function index() { return response()->json(Lead::query()->latest()->paginate(20)); } public function update(UpdateLeadRequest $request, Lead $lead) { $lead->update($request->validated()); return response()->json($lead->fresh()); } }

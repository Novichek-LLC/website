<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;

class LeadController extends Controller
{
    public function store(StoreLeadRequest $request)
    {
        $lead = Lead::create($request->validated());

        return response()->json([
            'message' => 'Lead stored',
            'lead' => $lead,
        ], 201);
    }
}

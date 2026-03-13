<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminLeadController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([]);
    }

    public function update(Request $request, string $lead): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'lead' => $lead,
        ]);
    }

    public function comment(Request $request, string $lead): JsonResponse
    {
        return response()->json([
            'ok' => true,
            'lead' => $lead,
        ]);
    }
}
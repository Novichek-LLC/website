<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientProject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $company = $user->clientCompany;

        if (! $company) {
            return response()->json([
                'message' => 'К пользователю не привязана компания клиента.',
            ], 404);
        }

        $projects = $company->projects()
            ->with('manager:id,name,email')
            ->latest()
            ->get();

        return response()->json($projects);
    }

    public function show(Request $request, ClientProject $project): JsonResponse
    {
        $user = $request->user();

        if (! $user->clientCompany || $project->client_company_id !== $user->clientCompany->id) {
            abort(403, 'Этот проект вам недоступен.');
        }

        $project->load('manager:id,name,email', 'company:id,name,slug,email,phone');

        return response()->json($project);
    }
}
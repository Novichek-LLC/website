<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientDashboardController extends Controller
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
            ->take(5)
            ->get();

        $stats = [
            'total_projects' => $company->projects()->count(),
            'active_projects' => $company->projects()->whereIn('status', ['new', 'in_progress', 'review', 'waiting_client'])->count(),
            'done_projects' => $company->projects()->where('status', 'done')->count(),
            'high_priority_projects' => $company->projects()->whereIn('priority', ['high', 'critical'])->count(),
        ];

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'company' => [
                'id' => $company->id,
                'name' => $company->name,
                'slug' => $company->slug,
                'contact_person' => $company->contact_person,
                'email' => $company->email,
                'phone' => $company->phone,
            ],
            'stats' => $stats,
            'projects' => $projects,
        ]);
    }
}
<?php
namespace App\Http\Controllers;
use App\Enums\LeadStatus;
use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use App\Services\TelegramNotifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
class LeadController extends Controller
{
    public function store(StoreLeadRequest $request, TelegramNotifier $telegram): JsonResponse
    {
        $lead = Lead::create([
            'service' => (string) $request->input('service'),
            'name' => (string) $request->input('name'),
            'company' => $request->input('company'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'telegram' => $request->input('telegram'),
            'message' => $request->input('message'),
            'budget' => $request->input('budget'),
            'status' => LeadStatus::NEW,
            'source' => 'site',
            'meta' => ['ip' => $request->ip(), 'user_agent' => $request->userAgent(), 'referer' => $request->headers->get('referer')],
        ]);
        $admins = User::query()->get();
        Notification::send($admins, new NewLeadNotification($lead));
        $telegram->send("<b>Новая заявка</b>\nУслуга: {$lead->service}\nИмя: {$lead->name}");
        return response()->json(['ok' => true, 'lead_id' => $lead->id], 201);
    }
}

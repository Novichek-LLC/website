<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Notifications\LeadCreatedNotification;
use Illuminate\Support\Facades\Notification;
class LeadController extends Controller {
    public function store(StoreLeadRequest $request) {
        $lead = Lead::create([...$request->validated(),'status' => 'new','pipeline_stage' => 'incoming','source' => $request->input('source', 'website'),'meta' => ['utm' => $request->input('utm', []),'ip' => $request->ip(),'user_agent' => $request->userAgent(),],]);
        Notification::route('mail', config('mail.from.address'))->notify(new LeadCreatedNotification($lead));
        return response()->json(['message' => 'Заявка отправлена. Мы свяжемся с вами в ближайшее время.','lead' => $lead,], 201);
    }
}

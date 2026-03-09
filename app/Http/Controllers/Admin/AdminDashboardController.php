<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogPost; use App\Models\CaseStudy; use App\Models\ChatConversation; use App\Models\Lead;
class AdminDashboardController extends Controller {
    public function __invoke() { return response()->json(['stats' => ['leads' => Lead::count(),'new_leads' => Lead::where('status','new')->count(),'open_chats' => ChatConversation::where('status','open')->count(),'blog_posts' => BlogPost::count(),'cases' => CaseStudy::count(),],'latest_leads' => Lead::latest()->limit(10)->get(),'pipeline' => Lead::query()->selectRaw('pipeline_stage, count(*) as total')->groupBy('pipeline_stage')->pluck('total','pipeline_stage'),]); }
}

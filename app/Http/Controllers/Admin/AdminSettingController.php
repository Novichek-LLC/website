<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\Setting; use Illuminate\Http\Request;
class AdminSettingController extends Controller { public function index() { return response()->json(Setting::all()->pluck('value', 'key')); } public function update(Request $request) { $payload = $request->validate(['seo_defaults' => ['nullable','array'],'contacts' => ['nullable','array'],'telegram' => ['nullable','array'],]); foreach ($payload as $key => $value) { Setting::updateOrCreate(['key' => $key], ['value' => $value]); } return response()->json(['saved' => true]); } }

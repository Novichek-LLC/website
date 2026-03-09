<?php
namespace App\Http\Controllers;
use App\Models\CaseStudy;
class CaseStudyController extends Controller { public function index() { return response()->json(CaseStudy::query()->where('status','published')->latest()->get()); } public function show(string $slug) { return response()->json(CaseStudy::query()->where('slug',$slug)->where('status','published')->firstOrFail()); } }

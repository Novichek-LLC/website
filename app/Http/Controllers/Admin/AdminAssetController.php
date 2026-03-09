<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use Illuminate\Http\Request;
class AdminAssetController extends Controller { public function store(Request $request) { $request->validate(['file' => ['required','file','max:10240'],'directory' => ['nullable','string'],]); $path = $request->file('file')->store($request->input('directory','uploads'),'public'); return response()->json(['path' => $path,'url' => asset('storage/'.$path),], 201); } }

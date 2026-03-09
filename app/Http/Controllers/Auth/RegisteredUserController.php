<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller; use App\Http\Requests\Auth\RegisterRequest; use App\Models\User; use Illuminate\Auth\Events\Registered; use Illuminate\Support\Facades\Auth;
class RegisteredUserController extends Controller { public function create() { abort_unless(User::count() === 0, 403); return view('auth.register'); } public function store(RegisterRequest $request) { abort_unless(User::count() === 0, 403); $user = User::create($request->validated()); event(new Registered($user)); Auth::login($user); return redirect('/admin'); } }

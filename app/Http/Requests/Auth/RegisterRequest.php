<?php
namespace App\Http\Requests\Auth;
use Illuminate\Foundation\Http\FormRequest; use Illuminate\Support\Facades\Hash; use Illuminate\Validation\Rules\Password;
class RegisterRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['name' => ['required','string','max:120'],'email' => ['required','email','max:120','unique:users,email'],'password' => ['required','confirmed', Password::defaults()],]; } public function validated($key = null, $default = null): array { $data = parent::validated($key, $default); $data['password'] = Hash::make($data['password']); return $data; } }

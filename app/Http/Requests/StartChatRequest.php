<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StartChatRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['name' => ['nullable','string','max:120'],'email' => ['nullable','email','max:120'],'phone' => ['nullable','string','max:40'],'message' => ['nullable','string','max:2000'],'source_url' => ['nullable','string','max:255'],]; } }

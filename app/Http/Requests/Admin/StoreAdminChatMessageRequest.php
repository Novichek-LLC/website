<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class StoreAdminChatMessageRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['message' => ['required','string','max:2000']]; } }

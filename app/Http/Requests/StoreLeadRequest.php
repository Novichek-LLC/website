<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreLeadRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'service' => ['required','string','max:255'],
            'name' => ['required','string','max:255'],
            'company' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'phone' => ['nullable','string','max:50'],
            'telegram' => ['nullable','string','max:255'],
            'message' => ['nullable','string','max:5000'],
            'budget' => ['nullable','integer','min:0'],
        ];
    }
}

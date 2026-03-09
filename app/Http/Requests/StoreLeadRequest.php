<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreLeadRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['name' => ['required','string','max:120'],'phone' => ['nullable','string','max:40'],'email' => ['nullable','email','max:120'],'company' => ['nullable','string','max:120'],'service' => ['required','string','max:120'],'message' => ['required','string','max:2000'],'budget' => ['nullable','string','max:120'],'source' => ['nullable','string','max:80'],'utm' => ['nullable','array'],]; } }

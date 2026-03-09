<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest;
class UpdateLeadRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['status' => ['nullable','in:new,in_progress,proposal,won,lost'],'pipeline_stage' => ['nullable','in:incoming,qualification,estimate,negotiation,implementation,done'],'assigned_to' => ['nullable','integer'],'budget' => ['nullable','string','max:120'],'message' => ['nullable','string','max:2000'],]; } }

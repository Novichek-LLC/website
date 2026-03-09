<?php
namespace App\Http\Requests\Admin;
use Illuminate\Foundation\Http\FormRequest; use Illuminate\Validation\Rule;
class StoreBlogPostRequest extends FormRequest { public function authorize(): bool { return true; } public function rules(): array { return ['title' => ['required','string','max:180'],'slug' => ['required','string','max:180'],'excerpt' => ['required','string','max:320'],'content' => ['required','string'],'status' => ['required', Rule::in(['draft','published'])],'cover' => ['nullable','image','max:4096'],'seo_title' => ['nullable','string','max:180'],'seo_description' => ['nullable','string','max:255'],'seo_keywords' => ['nullable','string','max:255'],'published_at' => ['nullable','date'],'author_id' => ['nullable','integer'],]; } }

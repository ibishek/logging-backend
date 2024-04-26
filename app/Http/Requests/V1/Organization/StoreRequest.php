<?php

namespace App\Http\Requests\V1\Organization;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'regex:/([A-Za-z.0-9\s])\w+/', 'min:5', 'max:75'],
            'description' => ['nullable', 'string', 'min:10', 'max:620'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'background_image' => ['nullable', 'image', 'mimes:png.jpg,jpeg,webp', 'max:3072'],
            'week_end' => ['nullable', 'array', 'min:1', 'max:4', Rule::in(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'])],
            'work_time' => ['required', 'numeric', 'min:60', 'max:600'],
            'break_time' => ['required', 'numeric', 'min:20', 'max:120'],
            'default_department_id' => ['nullable', 'string', 'min:2', 'max:95', 'exists:departments,slug'],
            'default_project_id' => ['nullable', 'string', 'min:2', 'max:95', 'exists:projects,slug'],
            'set_default' => ['required', 'boolean'],
        ];
    }
}

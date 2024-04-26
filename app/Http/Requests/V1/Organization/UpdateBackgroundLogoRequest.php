<?php

namespace App\Http\Requests\V1\Organization;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBackgroundLogoRequest extends FormRequest
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
            'background_image' => ['nullable', 'image', 'mimes:png.jpg,jpeg,webp', 'max:3072'],
        ];
    }
}

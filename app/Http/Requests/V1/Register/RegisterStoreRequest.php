<?php

namespace App\Http\Requests\V1\Register;

use App\Enums\UserGender;
use App\Enums\UserMaritalStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'min:2', 'max:35'],
            'last_name' => ['required', 'min:2', 'max:65'],
            'email' => ['required', 'email', 'min:2', 'max:244', 'unique:users,email'],
            'password' => ['required', 'min:5', 'max:45'],
            'gender' => ['required', Rule::in(UserGender::toArray())],
            'marital_status' => ['required', Rule::in(UserMaritalStatus::toArray())],
        ];
    }
}

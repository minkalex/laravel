<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'last_name' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|max:255|email:rfc,dns',
            'password' => 'max:255',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'max' => "Максимальная длина поля :max символов.",
            'email.unique' => 'Пользователь с таким e-mail уже существует.',
            'email.email' => 'Введите корректный e-mail.',
        ];
    }
}

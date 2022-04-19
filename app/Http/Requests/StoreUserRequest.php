<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255|email:rfc,dns',
            'password' => 'required|max:255',
            'repeat_password' => 'required|max:255',
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

<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос авторизации пользователя",
    description: "Тело запроса для авторизации пользователя",
    required: ["email", "password"],
    properties: [
        new OA\Property(
            property: "email",
            description: "Email пользователя",
            type: "string",
            format: "email"
        ),
        new OA\Property(
            property: "password",
            description: "Пароль пользователя",
            type: "string",
            format: "password"
        ),
    ]
)]
/**
 * @property-read string $email
 * @property-read string $password
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Электронная почта обязательна для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'password.required' => 'Пароль обязателен.',
        ];
    }
}

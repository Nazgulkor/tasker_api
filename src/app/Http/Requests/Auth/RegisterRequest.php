<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос регистрации пользователя",
    description: "Тело запроса для регистрации пользователя",
    required: ["name", "email", "password"],
    properties: [
        new OA\Property(
            property: "name",
            description: "Имя пользователя",
            type: "string"
        ),
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
        new OA\Property(
            property: "password_confirmation",
            description: "Подтверждение пароля пользователя",
            type: "string",
            format: "password"
        ),
        new OA\Property(
            property: "is_admin",
            description: "Администратор или нет",
            type: "boolean"
        ),
    ]
)]
/**
 * @property-read string $name
 * @property-read string $email
 * @property-read string $password
 * @property-read bool $is_admin
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->has('is_admin')) {
            $this->merge(['is_admin' => false,]);
        }
    }

    /**
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'is_admin' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Имя обязательно для заполнения.',
            'email.required' => 'Электронная почта обязательна для заполнения.',
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.unique' => 'Этот адрес электронной почты уже занят.',
            'password.required' => 'Пароль обязателен.',
            'password.confirmed' => 'Пароли не совпадают.',
        ];
    }
}

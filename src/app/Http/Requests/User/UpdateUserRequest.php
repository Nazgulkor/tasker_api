<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос обновления пользователя",
    description: "Тело запроса для обновления пользователя",
    required: ["name", "email"],
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
    ]
)]
/**
 * @property-read string $name
 * @property-read string $email
 */
class UpdateUserRequest extends FormRequest
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
            'name' => 'string|max:255',
            'email' => ['email', Rule::unique('users')->ignore(auth()->id())],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'Введите действительный адрес электронной почты.',
            'email.unique' => 'Этот адрес электронной почты уже занят.',
        ];
    }
}

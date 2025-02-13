<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос создания задачи",
    description: "Тело запроса для создания задачи",
    required: ["title", "content"],
    properties: [
        new OA\Property(
            property: "title",
            description: "Название задачи",
            type: "string"
        ),
        new OA\Property(
            property: "content",
            description: "Описание задачи",
            type: "string"
        ),
    ]
)]
/** 
 * @property-read string $title
 * @property-read string $content  
 */
class StoreTasksRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'content.required' => 'Контент обязателен.',
        ];
    }
}

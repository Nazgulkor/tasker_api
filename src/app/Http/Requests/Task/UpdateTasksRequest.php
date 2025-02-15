<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Enum\TaskStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос обновления задачи",
    description: "Тело запроса для обновления задачи",
    required: ["title", "content", "status"],
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
        new OA\Property(
            property: "status",
            description: "Статус задачи",
            type: "string",
            enum: [
                TaskStatusEnum::STATUS_ASSIGNED,
                TaskStatusEnum::STATUS_ACCEPTED,
                TaskStatusEnum::STATUS_RESOLVED,
                TaskStatusEnum::STATUS_REJECTED,
            ]
        ),
    ]
)]
/**
 * @property-read string $title
 * @property-read string $content
 * @property-read string $status
 */
class UpdateTasksRequest extends FormRequest
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
            'status' => ['required', Rule::in(TaskStatusEnum::cases())],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'content.required' => 'Контент обязателен.',
            'status.required' => 'Поле "Статус" обязательно для заполнения.',
            'status.in' => 'Выбранный статус недействителен. Он должен быть одним из: assigned, accepted, resolved, rejected.',
        ];
    }
}

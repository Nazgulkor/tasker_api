<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Enum\TaskStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Запрос поиска задач",
    description: "Тело запроса для поиска задач",
    properties: [
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
 * @property-read string $status
 */
class SearchTasksRequest extends FormRequest
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
            'status' => [Rule::in(TaskStatusEnum::cases())],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'Выбранный статус недействителен. Он должен быть одним из: assigned, accepted, resolved, rejected.',
        ];
    }
}

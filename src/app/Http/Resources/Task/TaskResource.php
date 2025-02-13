<?php

declare(strict_types=1);

namespace App\Http\Resources\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    title: "Ресурс задачи",
    description: "Ресурс задачи",
    properties: [
        new OA\Property(
            property: "id",
            description: "ID задачи",
            type: "integer"
        ),
        new OA\Property(
            property: "title",
            description: "Название задачи",
            type: "string"
        ),
        new OA\Property(
            property: "description",
            description: "Описание задачи",
            type: "string"
        ),
        new OA\Property(
            property: "status",
            description: "Статус задачи",
            type: "string"
        ),
        new OA\Property(
            property: "created_at",
            description: "Дата создания задачи",
            type: "string",
            format: "date-time"
        ),
        new OA\Property(
            property: "updated_at",
            description: "Дата обновления задачи",
            type: "string",
            format: "date-time"
        ),
    ]
)]
/**
 * @mixin Task
 */
class TaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

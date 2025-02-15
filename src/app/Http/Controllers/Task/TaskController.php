<?php

declare(strict_types=1);

namespace App\Http\Controllers\Task;

use App\Enum\TaskStatusEnum;
use App\Http\ApiSpec;
use App\Http\Requests\Task\SearchTasksRequest;
use App\Http\Requests\Task\StoreTasksRequest;
use App\Http\Requests\Task\UpdateTasksRequest;
use App\Http\Resources\Task\TaskResource;
use App\Http\Responses\FailResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Task;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Tasks', description: 'Задачи')]
final class TaskController
{
    #[OA\Get(
        path: '/api/tasks',
        summary: 'Получение списка задач',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Tasks'],
        parameters: [
            new OA\Parameter(
                name: 'status',
                description: 'Статус задачи',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    enum: [
                        TaskStatusEnum::STATUS_ASSIGNED,
                        TaskStatusEnum::STATUS_ACCEPTED,
                        TaskStatusEnum::STATUS_RESOLVED,
                        TaskStatusEnum::STATUS_REJECTED,
                    ]
                )
            ),
        ],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'tasks',
                        type: 'array',
                        items: new OA\Items(
                            ref: TaskResource::class
                        )
                    ),
                ],
            ),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function index(SearchTasksRequest $request): JsonResponse
    {
        $tasks = Task::whereUserId(Auth::id());

        if ($request->status) {
            $tasks->where('status', $request->status);
        }

        return new SuccessResponse(['tasks' => TaskResource::collection($tasks->get())]);
    }

    #[OA\Get(
        path: '/api/tasks/{id}',
        summary: 'Получение задачи по ID',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Tasks'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'task',
                        ref: TaskResource::class
                    ),
                ],
            ),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function show(int $id): JsonResponse
    {
        try {
            $task = Task::whereUserId(Auth::id())
                ->whereId($id)
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            return new FailResponse('Задача не найдена', 404);
        }

        return new SuccessResponse(['task' => new TaskResource($task)]);
    }


    #[OA\Put(
        path: '/api/tasks/{id}',
        summary: 'Обновление задачи',
        security: [
            ['bearerAuth' => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: UpdateTasksRequest::class
            )
        ),
        tags: ['Tasks'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'task',
                        ref: TaskResource::class
                    ),
                ],
            ),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\BadRequestResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function update(UpdateTasksRequest $request, int $id): JsonResponse
    {
        try {
            $task = Task::whereUserId(Auth::id())
                ->whereId($id)
                ->firstOrFail();
            $task->updateOrFail($request->toArray());
            $task->refresh();
        } catch (ModelNotFoundException) {
            return new FailResponse('Задача не найдена', 404);
        }

        return new SuccessResponse(['task' => new TaskResource($task)]);
    }

    #[OA\Post(
        path: '/api/tasks',
        summary: 'Создание новой задачи',
        security: [
            ['bearerAuth' => []]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                ref: StoreTasksRequest::class
            )
        ),
        tags: ['Tasks'],
        responses: [
            new ApiSpec\SuccessResponse(
                properties: [
                    new OA\Property(
                        property: 'task',
                        ref: TaskResource::class
                    ),
                ],
            ),
            new ApiSpec\BadRequestResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function store(StoreTasksRequest $request): JsonResponse
    {
        $task = Task::factory()->create([
            'user_id' => Auth::id(),
            ...$request->toArray()
        ]);

        return new SuccessResponse(['task' => new TaskResource($task)], 201);
    }

    #[OA\Delete(
        path: '/api/tasks/{id}',
        summary: 'Удаление задачи',
        security: [
            ['bearerAuth' => []]
        ],
        tags: ['Tasks'],
        responses: [
            new ApiSpec\SuccessResponse(),
            new ApiSpec\NotFoundResponse(),
            new ApiSpec\UnauthorizedResponse(),
        ]
    )]
    public function destroy(int $id): JsonResponse
    {
        try {
            $task = Task::whereUserId(Auth::id())
                ->whereId($id)
                ->firstOrFail();
            $task->deleteOrFail();
        } catch (ModelNotFoundException) {
            return new FailResponse('Задача не найдена', 404);
        }

        return new SuccessResponse();
    }
}

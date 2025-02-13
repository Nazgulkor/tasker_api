<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\TaskRequest;
use App\Http\Requests\User\TaskUpdateRequest;
use App\Http\Resources\User\TaskResource;
use App\Services\User\TaskService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService,
    ) { }

    /**
     * @throws Exception
     */
    public function tasks(Request $request): JsonResponse
    {
        $tasks = $this->taskService->getTasksByUserId($request->user()->id);

        return response()->json([
            'task' => TaskResource::collection($tasks),
        ]);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found.'], 404);
        }

        return response()->json([
            'task' => new TaskResource($task),
        ]);
    }

    public function update(TaskUpdateRequest $request, int $id): JsonResponse
    {
        $task = $request->validated();

        $updatedTask = $this->taskService->updateTask($id, $task);

        if (!$updatedTask) {
            return response()->json(['message' => 'Unauthorized or Task not found'], 403);
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => new TaskResource($updatedTask),
        ]);
    }

    /**
     * @throws Exception
     */
    public function create(TaskRequest $request): JsonResponse
    {
        $data = $request->validated();

        $createdTask = $this->taskService->createTask($data);

        return response()->json([
            'message' => 'Successfully created task!',
            'task' => new TaskResource($createdTask),
        ], 201);
    }

    public function delete(int $id): JsonResponse
    {
        if (!$this->taskService->deleteTask($id)) {
            return response()->json(['message' => 'Unauthorized or Task not found'], 403);
        }

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}

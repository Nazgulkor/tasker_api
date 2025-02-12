<?php

namespace App\Services\User;

use App\Models\Task;
use App\Repositories\User\TaskRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class TaskService
{
    public function __construct(
        private TaskRepository $taskRepository
    ){

    }

    /**
     * Добавление новой задачи
     *
     * @param array $task
     * @return Task
     * @throws Exception
     */
    public function createTask(array $task): Task
    {
        try{
            return $this->taskRepository->create($task);
        } catch (Exception $e) {
            throw new Exception('Error creating task: ' . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function getTasksByUserId(int $userId): Collection
    {
        try{
            return $this->taskRepository->getTasksByUserId($userId);
        } catch (Exception $e) {
            throw new Exception('Error taking tasks: ' . $e->getMessage());
        }
    }

    public function updateTask(int $taskId, array $taskData): ?Task
    {
        $task = $this->taskRepository->getTaskById($taskId);

        if (!$task || !$this->userCanUpdateOrDeleteAnyTask($task)) {
            return null;
        }

        return $this->taskRepository->updateTask($task, $taskData);
    }

    private function userCanUpdateOrDeleteAnyTask(Task $task): bool
    {
        if (Auth::id() !== $task['user_id'] && !Auth::user()->hasRole('admin')) {
            return false;
        }

        return true;
    }

    public function getTaskById(int $taskId): ?Task
    {
        return $this->taskRepository->getTaskById($taskId);
    }

    public function deleteTask(int $taskId): bool
    {
        $task = $this->taskRepository->getTaskById($taskId);

        if (!$task || !$this->userCanUpdateOrDeleteAnyTask($task)) {
            return false;
        }

        return $this->taskRepository->deleteTask($task);
    }
}

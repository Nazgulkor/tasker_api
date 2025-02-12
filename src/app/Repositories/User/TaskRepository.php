<?php

namespace App\Repositories\User;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function getTasksByUserId(int $user_id): Collection
    {
        return Task::with('user')->where('user_id', $user_id)->get();
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update($data);

        return $task->refresh();
    }

    public function getTaskById(int $taskId): ?Task
    {
        return Task::with('user')->find($taskId);
    }

    public function deleteTask(Task $task): bool
    {
        return $task->delete();
    }
}

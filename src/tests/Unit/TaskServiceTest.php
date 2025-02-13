<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Task;
use App\Repositories\User\TaskRepository;
use App\Services\User\TaskService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use PHPUnit\Framework\TestCase;

class TaskServiceTest extends TestCase
{
    private $taskService;
    private $taskRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskRepositoryMock = Mockery::mock(TaskRepository::class);

        $this->taskService = new TaskService($this->taskRepositoryMock);
    }

    public function test_createTask_creates_task_successfully()
    {
        $taskData = ['title' => 'Test Task', 'description' => 'Test Description', 'user_id' => 1];

        $this->taskRepositoryMock->shouldReceive('create')
            ->once()
            ->with($taskData)
            ->andReturn(new Task($taskData));

        $task = $this->taskService->createTask($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals($taskData['title'], $task->title);
    }

    public function test_createTask_throws_exception_when_error_occurs()
    {
        $taskData = ['title' => 'Test Task', 'description' => 'Test Description', 'user_id' => 1];

        $this->taskRepositoryMock->shouldReceive('create')
            ->once()
            ->with($taskData)
            ->andThrow(new \Exception('Error creating task'));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Error creating task');

        $this->taskService->createTask($taskData);
    }

    public function test_getTasksByUserId_returns_tasks()
    {
        $tasksCollection = Mockery::mock(Collection::class);
        $userId = 1;

        $this->taskRepositoryMock->shouldReceive('getTasksByUserId')
            ->once()
            ->with($userId)
            ->andReturn($tasksCollection);

        $tasks = $this->taskService->getTasksByUserId($userId);

        $this->assertSame($tasksCollection, $tasks);
    }

    public function test_updateTask_returns_null_if_task_not_found()
    {
        $taskId = 999;
        $taskData = ['title' => 'Updated Task'];

        $this->taskRepositoryMock->shouldReceive('getTaskById')
            ->once()
            ->with($taskId)
            ->andReturn(null);

        $updatedTask = $this->taskService->updateTask($taskId, $taskData);

        $this->assertNull($updatedTask);
    }

    public function test_deleteTask_returns_false_if_task_not_found()
    {
        $taskId = 999;

        $this->taskRepositoryMock->shouldReceive('getTaskById')
            ->once()
            ->with($taskId)
            ->andReturn(null);

        $result = $this->taskService->deleteTask($taskId);

        $this->assertFalse($result);
    }
}

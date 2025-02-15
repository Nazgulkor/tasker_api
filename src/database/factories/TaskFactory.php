<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enum\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => TaskStatusEnum::STATUS_ASSIGNED
        ];
    }
}

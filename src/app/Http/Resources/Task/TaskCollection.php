<?php

declare(strict_types=1);

namespace App\Http\Resources\Task;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    /**
     * @return array<Task>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->toArray();
    }
}

<?php

declare(strict_types=1);

namespace App\Enum;

enum TaskStatusEnum: string
{
    case STATUS_ASSIGNED = 'assigned';
    case STATUS_ACCEPTED = 'accepted';
    case STATUS_RESOLVED = 'resolved';
    case STATUS_REJECTED = 'rejected';
}

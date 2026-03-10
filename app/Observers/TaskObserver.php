<?php

declare(strict_types=1);

namespace App\Observers;

use App\Jobs\SyncTaskToCalendarJob;
use App\Models\Task;

class TaskObserver
{
    public function created(Task $task): void
    {
        SyncTaskToCalendarJob::dispatch($task);
    }

    public function updated(Task $task): void
    {
        SyncTaskToCalendarJob::dispatch($task);
    }
}

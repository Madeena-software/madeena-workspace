<?php

declare(strict_types=1);

namespace App\Services\Integrations;

use App\Models\Task;

class GoogleCalendarService
{
    /**
     * Sync a task to Google Calendar.
     */
    public function syncTask(Task $task): bool
    {
        // TODO: Implement Google Calendar sync logic
        return false;
    }
}

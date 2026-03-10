<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Task;
use App\Services\Integrations\GoogleCalendarService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncTaskToCalendarJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly Task $task,
    ) {}

    public function handle(GoogleCalendarService $service): void
    {
        $service->syncTask($this->task);
    }
}

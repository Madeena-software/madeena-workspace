<?php

namespace Tests\Unit;

use App\Services\AI\TaskExtractionService;
use App\Services\Integrations\GoogleCalendarService;
use Tests\TestCase;

class ServiceSkeletonTest extends TestCase
{
    public function test_task_extraction_service_returns_array(): void
    {
        $service = new TaskExtractionService();
        $result = $service->extractFromText('Create a task for testing');

        $this->assertIsArray($result);
    }

    public function test_google_calendar_service_returns_bool(): void
    {
        $service = new GoogleCalendarService();
        $task = new \App\Models\Task();

        $result = $service->syncTask($task);

        $this->assertIsBool($result);
    }
}

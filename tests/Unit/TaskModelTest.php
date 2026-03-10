<?php

namespace Tests\Unit;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_task_can_be_created(): void
    {
        $task = Task::factory()->create([
            'title' => 'Test Task',
            'status' => TaskStatus::TODO,
            'priority' => TaskPriority::HIGH,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'status' => 'todo',
            'priority' => 'high',
        ]);
    }

    public function test_task_casts_enums(): void
    {
        $task = Task::factory()->create([
            'status' => TaskStatus::IN_PROGRESS,
            'priority' => TaskPriority::LOW,
        ]);

        $this->assertInstanceOf(TaskStatus::class, $task->status);
        $this->assertInstanceOf(TaskPriority::class, $task->priority);
    }

    public function test_task_belongs_to_project(): void
    {
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        $this->assertEquals($project->id, $task->project->id);
    }

    public function test_task_belongs_to_milestone(): void
    {
        $milestone = Milestone::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $milestone->project_id,
            'milestone_id' => $milestone->id,
        ]);

        $this->assertEquals($milestone->id, $task->milestone->id);
    }

    public function test_task_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $task->user->id);
    }

    public function test_task_can_be_soft_deleted(): void
    {
        $task = Task::factory()->create();
        $task->delete();

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
        $this->assertNotNull(Task::withTrashed()->find($task->id));
    }

    public function test_task_can_be_created_without_project(): void
    {
        $task = Task::factory()->create([
            'project_id' => null,
            'milestone_id' => null,
        ]);

        $this->assertNull($task->project_id);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'project_id' => null]);
    }

    public function test_task_status_enum_labels(): void
    {
        $this->assertEquals('Backlog', TaskStatus::BACKLOG->label());
        $this->assertEquals('To Do', TaskStatus::TODO->label());
        $this->assertEquals('In Progress', TaskStatus::IN_PROGRESS->label());
        $this->assertEquals('Review', TaskStatus::REVIEW->label());
        $this->assertEquals('Done', TaskStatus::DONE->label());
    }

    public function test_task_priority_enum_labels(): void
    {
        $this->assertEquals('Low', TaskPriority::LOW->label());
        $this->assertEquals('Medium', TaskPriority::MEDIUM->label());
        $this->assertEquals('High', TaskPriority::HIGH->label());
    }
}

<?php

namespace Tests\Unit;

use App\Enums\ProjectType;
use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_project_can_be_created(): void
    {
        $project = Project::factory()->create([
            'name' => 'Test Project',
            'key' => 'TST',
            'type' => ProjectType::AGILE,
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
            'key' => 'TST',
            'type' => 'agile',
        ]);
        $this->assertInstanceOf(ProjectType::class, $project->type);
    }

    public function test_project_has_milestones_relationship(): void
    {
        $project = Project::factory()->create();
        Milestone::factory()->count(3)->create(['project_id' => $project->id]);

        $this->assertCount(3, $project->milestones);
    }

    public function test_project_has_tasks_relationship(): void
    {
        $project = Project::factory()->create();
        Task::factory()->count(2)->create(['project_id' => $project->id]);

        $this->assertCount(2, $project->tasks);
    }

    public function test_project_type_enum_has_labels(): void
    {
        $this->assertEquals('Agile', ProjectType::AGILE->label());
        $this->assertEquals('Waterfall', ProjectType::WATERFALL->label());
        $this->assertEquals('Simple', ProjectType::SIMPLE->label());
    }
}

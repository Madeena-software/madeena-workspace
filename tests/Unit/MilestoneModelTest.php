<?php

namespace Tests\Unit;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MilestoneModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_milestone_can_be_created(): void
    {
        $milestone = Milestone::factory()->create([
            'name' => 'Sprint 1',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('milestones', [
            'name' => 'Sprint 1',
            'is_active' => true,
        ]);
    }

    public function test_milestone_belongs_to_project(): void
    {
        $project = Project::factory()->create();
        $milestone = Milestone::factory()->create(['project_id' => $project->id]);

        $this->assertEquals($project->id, $milestone->project->id);
    }

    public function test_milestone_has_tasks_relationship(): void
    {
        $milestone = Milestone::factory()->create();
        Task::factory()->count(2)->create([
            'project_id' => $milestone->project_id,
            'milestone_id' => $milestone->id,
        ]);

        $this->assertCount(2, $milestone->tasks);
    }

    public function test_milestone_casts_dates(): void
    {
        $milestone = Milestone::factory()->create([
            'start_date' => '2026-01-01',
            'end_date' => '2026-01-31',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $milestone->start_date);
        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $milestone->end_date);
    }
}

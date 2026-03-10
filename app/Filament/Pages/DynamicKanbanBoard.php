<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class DynamicKanbanBoard extends KanbanBoard
{
    protected static string $model = Task::class;

    protected static string $statusEnum = TaskStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $title = 'Kanban Board';

    protected static ?string $navigationGroup = 'Project Management';

    protected function records(): Collection
    {
        $query = $this->getEloquentQuery();

        $projectId = request()->query('project_id');

        if ($projectId) {
            $query->where('project_id', $projectId);

            $project = \App\Models\Project::find($projectId);
            if ($project && $project->type === \App\Enums\ProjectType::AGILE) {
                $query->whereHas('milestone', fn (Builder $q) => $q->where('is_active', true));
            }
        } else {
            $query->whereNull('project_id');
        }

        return $query->get();
    }

    public function onStatusChanged(int|string $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        Task::where('id', $recordId)->update([
            'status' => $status,
        ]);
    }
}

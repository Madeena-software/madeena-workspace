<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Project Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\Select::make('milestone_id')
                    ->relationship('milestone', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('task_code')
                    ->maxLength(50),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->options(collect(TaskStatus::cases())->mapWithKeys(
                        fn (TaskStatus $status) => [$status->value => $status->label()]
                    ))
                    ->required()
                    ->default(TaskStatus::BACKLOG->value),
                Forms\Components\Select::make('priority')
                    ->options(collect(TaskPriority::cases())->mapWithKeys(
                        fn (TaskPriority $priority) => [$priority->value => $priority->label()]
                    ))
                    ->required()
                    ->default(TaskPriority::MEDIUM->value),
                Forms\Components\DateTimePicker::make('due_date'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->label('Assignee'),
                Forms\Components\TextInput::make('external_reference_id')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('project.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge(),
                Tables\Columns\TextColumn::make('priority')
                    ->badge(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Assignee')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}

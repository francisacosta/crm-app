<?php

namespace App\Filament\Pages;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Relaticle\Flowforge\Board;
use Relaticle\Flowforge\BoardPage;
use Relaticle\Flowforge\Column;
use Relaticle\Flowforge\Components\CardFlex;

class TaskBoard extends BoardPage
{
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-view-columns';

    protected static ?string $navigationLabel = 'Task Board';

    protected static ?string $title = 'Task Board';

    public function board(Board $board): Board
    {
        return $board
            ->searchable([
                'title',
            ])
            ->query($this->getEloquentQuery())
            ->recordTitleAttribute('title')
            ->columnIdentifier('status')
            ->positionIdentifier('position')
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(TaskStatus::class),
                SelectFilter::make('priority')
                    ->multiple()
                    ->options(TaskPriority::class),
                Filter::make('due_date_range')
                    ->form([
                        DatePicker::make('due_date_from')
                            ->label('Due Date From'),
                        DatePicker::make('due_date_to')
                            ->label('Due Date To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['due_date_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                            )
                            ->when(
                                $data['due_date_to'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                            );
                    }),
                Filter::make('created_at_range')
                    ->form([
                        DatePicker::make('created_at_from')
                            ->label('Created From'),
                        DatePicker::make('due_date_to')
                            ->label('Created To'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_at_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_at_to'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
                SelectFilter::make('assigned_to')
                    ->relationship('assignedTo', 'name')
                    ->label('Assigned To'),
            ])
            ->filtersLayout(FiltersLayout::AboveContentCollapsible)
            ->recordActions([
                Action::make('edit')
                    ->icon(Heroicon::PencilSquare)
                    // ->url(fn (Task $record): string => route('filament.admin.resources.tasks.edit', $record)),                Action::make('view')
                    ->icon(Heroicon::Eye)
                // ->url(fn (Task $record): string => route('filament.admin.resources.tasks.view', $record)),
                ,
            ])
            ->cardSchema(function (Schema $schema): Schema {
                return $schema->schema([
                    // TextEntry::make('priority')
                    //     ->badge()
                    //     ->color(fn (Task $record): string => $record->priority?->getColor() ?? 'gray'),

                    CardFlex::make([
                        TextEntry::make('priority')
                            ->label('Priority:')
                            ->badge()
                            ->icon('heroicon-o-flag'),

                        TextEntry::make('assignedTo.name')
                            ->badge()
                            ->label('Assigned To:')
                            ->icon('heroicon-o-user'),
                    ])->wrap()->justify('start'),

                    CardFlex::make([
                        TextEntry::make('created_at')
                            ->label('Created:')
                            ->formatStateUsing(fn ($state) => $state?->format('M d, Y') ?? '—')
                            ->icon('heroicon-o-calendar'),
                        TextEntry::make('due_date')
                            ->label('Due:')
                            ->formatStateUsing(fn ($state) => $state?->format('M d, Y') ?? '—')
                            ->icon('heroicon-o-calendar'),
                    ]),
                ]);
            })
            ->columns([
                Column::make('open')->label('Open')->color('gray'),
                Column::make('in_progress')->label('In Progress')->color('blue'),
                Column::make('completed')->label('Completed')->color('green'),
            ]);
    }

    public function getEloquentQuery(): Builder
    {
        return Task::query();
    }
}

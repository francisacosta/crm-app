<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UserAssignmentsTable extends TableWidget
{
    protected static ?string $icon = 'heroicon-o-users';

    protected static ?string $heading = 'Tasks assigned by Users';

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()
                ->withCount([
                    'assignedTasks as total_assigned',
                    'assignedTasks as open_assigned' => fn ($q) => $q->whereIn('status', ['open', 'in_progress']),
                    'assignedTasks as completed_assigned' => fn ($q) => $q->where('status', 'completed'),
                    'assignedTasks as cancelled_assigned' => fn ($q) => $q->where('status', 'cancelled'),
                ])
            )
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('total_assigned')
                    ->label('Assigned')
                    ->sortable(),
                TextColumn::make('open_assigned')
                    ->label('Open')
                    ->sortable(),
                TextColumn::make('completed_assigned')
                    ->label('Completed')
                    ->sortable(),
                TextColumn::make('cancelled_assigned')
                    ->label('Cancelled')
                    ->sortable(),
            ])
            ->defaultSort('total_assigned', 'desc');
    }
}

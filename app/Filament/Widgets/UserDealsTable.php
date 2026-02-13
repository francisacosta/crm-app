<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class UserDealsTable extends TableWidget
{
    protected static ?string $icon = 'heroicon-o-briefcase';

    protected static ?string $heading = 'Deals assigned by Users';

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()
                ->withCount([
                    'deals as total_deals',
                    'deals as open_deals' => fn ($q) => $q->whereIn('status', ['prospecting', 'qualification', 'negotiation']),
                    'deals as won_deals' => fn ($q) => $q->where('status', 'won'),
                    'deals as lost_deals' => fn ($q) => $q->where('status', 'lost'),
                ])
            )
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('total_deals')
                    ->label('Deals')
                    ->sortable(),
                TextColumn::make('open_deals')
                    ->label('Open')
                    ->sortable(),
                TextColumn::make('won_deals')
                    ->label('Won')
                    ->sortable(),
                TextColumn::make('lost_deals')
                    ->label('Lost')
                    ->sortable(),
            ])
            ->defaultSort('total_deals', 'desc');
    }
}

<?php

namespace App\Filament\Resources\Deals\Tables;

use App\Enums\DealStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DealsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                'company.name',
                'user.name',
            ])
            ->columns([
                TextColumn::make('name')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->toggleable()
                    ->money('USD')
                    ->summarize([
                        Average::make()->money('USD'),
                        Sum::make()->money('USD'),
                    ])
                    ->sortable(),
                TextColumn::make('status')
                    ->toggleable()
                    ->badge()
                    ->sortable(),
                TextColumn::make('expected_close_date')
                    ->toggleable()
                    ->date()
                    ->sortable(),
                TextColumn::make('company.name')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->toggleable()
                    ->label('Assigned To')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date Created')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('assigned_to')
                    ->relationship('user', 'name')
                    ->label('Assigned To'),
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                SelectFilter::make('status')
                    ->multiple()
                    ->options(DealStatus::class),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

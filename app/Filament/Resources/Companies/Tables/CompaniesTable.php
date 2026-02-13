<?php

namespace App\Filament\Resources\Companies\Tables;

use App\Models\Company;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('phone')
                    ->toggleable(),
                TextColumn::make('city')
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Owner')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
                SelectFilter::make('user_id')->relationship('user', 'name')->label('Owner'),
                SelectFilter::make('city')
                    ->label('City')
                    ->searchable()
                    ->options(fn (): array => Company::query()
                        ->whereNotNull('city')
                        ->where('city', '!=', '')
                        ->orderBy('city')
                        ->pluck('city', 'city')
                        ->all()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make(),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

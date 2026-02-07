<?php

namespace App\Filament\Resources\Deals\Schemas;

use App\Enums\DealStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DealForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Deal Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('value')
                            ->numeric()
                            ->prefix('$'),
                        Select::make('status')
                            ->options(DealStatus::asSelect())
                            ->required(),
                        DatePicker::make('expected_close_date'),
                        Select::make('company_id')
                            ->relationship('company', 'name')
                            ->required(),
                        Select::make('contact_id')
                            ->relationship('contact', 'first_name'),
                    ]),
                Section::make('Additional Information')
                    ->components([
                        Textarea::make('notes')
                            ->maxLength(65535),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                    ]),
            ]);
    }
}

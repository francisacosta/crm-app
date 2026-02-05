<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Company Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('website')
                            ->url()
                            ->maxLength(255),
                    ]),
                Section::make('Address')
                    ->columns(2)
                    ->components([
                        Textarea::make('address')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->maxLength(100),
                        TextInput::make('state')
                            ->maxLength(100),
                        TextInput::make('postal_code')
                            ->maxLength(20),
                        TextInput::make('country')
                            ->maxLength(100),
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

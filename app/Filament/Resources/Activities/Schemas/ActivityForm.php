<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Information')
                    ->columns(2)
                    ->components([
                        Select::make('type')
                            ->options([
                                'call' => 'Call',
                                'email' => 'Email',
                                'meeting' => 'Meeting',
                                'note' => 'Note',
                            ])
                            ->required(),
                        DateTimePicker::make('activity_date'),
                        Textarea::make('content')
                            ->required()
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
                Section::make('Relationships')
                    ->columns(2)
                    ->components([
                        Select::make('company_id')
                            ->relationship('company', 'name'),
                        Select::make('contact_id')
                            ->relationship('contact', 'first_name'),
                        Select::make('deal_id')
                            ->relationship('deal', 'name'),
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required(),
                    ]),
            ]);
    }
}

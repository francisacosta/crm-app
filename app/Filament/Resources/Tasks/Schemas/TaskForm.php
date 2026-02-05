<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Task Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Select::make('status')
                            ->options([
                                'open' => 'Open',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required(),
                        Select::make('priority')
                            ->options([
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                            ])
                            ->required(),
                        DateTimePicker::make('due_date'),
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
                        Select::make('assigned_to')
                            ->relationship('assignedTo', 'name')
                            ->required(),
                        Select::make('created_by')
                            ->relationship('createdBy', 'name')
                            ->required(),
                    ]),
            ]);
    }
}

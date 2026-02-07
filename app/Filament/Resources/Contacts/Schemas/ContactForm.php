<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Filament\Resources\Companies\Schemas\CompanyForm;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->columns(2)
                    ->components([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('job_title')
                            ->maxLength(255),
                        Select::make('company_id')
                            ->createOptionForm(CompanyForm::configure(Schema::make())->getComponents())
                            ->relationship('company', 'name'),
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

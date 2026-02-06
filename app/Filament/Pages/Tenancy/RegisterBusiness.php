<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Business;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Tenancy\RegisterTenant;
use Filament\Schemas\Schema;

class RegisterBusiness extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register business';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Business::class, 'slug'),
                Textarea::make('description')
                    ->maxLength(65535),
            ]);
    }

    protected function handleRegistration(array $data): Business
    {
        $business = Business::create($data);

        $business->users()->attach(auth()->user());

        return $business;
    }
}

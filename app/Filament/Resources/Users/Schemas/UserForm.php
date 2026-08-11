<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                Select::make('roles')
                    ->relationship('roles', 'name') // Automatically fetches roles from the DB
                    ->multiple() // Allows a user to have multiple roles (e.g., Scout + Manager)
                    ->preload()   // Loads the list immediately for a better UI
                    ->searchable()
                    ->required(),
                Toggle::make('is_admin')
                    ->label('Admin Access')
                    ->helperText('Enable to allow user access to the /admin portal.')
                    ->onIcon('heroicon-m-shield-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('success')
                    ->offColor('danger'),
            ]);
    }
}

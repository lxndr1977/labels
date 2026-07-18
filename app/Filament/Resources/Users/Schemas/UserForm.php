<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRoleEnum;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DateTimePicker;

class UserForm
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([
            Section::make('Informações do usuário')
               ->schema([
                  Grid::make()
                     ->columns(2)
                     ->schema([
                        TextInput::make('name')
                           ->label('Nome')
                           ->required(),

                        TextInput::make('email')
                           ->label('Email')
                           ->email()
                           ->unique(ignoreRecord: true)
                           ->required(),

                        Select::make('role')
                           ->label('Função')
                           ->options(UserRoleEnum::class)
                           ->required(),

                        TextInput::make('password')
                           ->label('Senha')
                           ->password()
                           ->required(fn(string $operation): bool => $operation === 'create')
                           ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                           ->dehydrated(fn(?string $state): bool => filled($state))
                           ->columns(2),
                     ])

               ])
               ->columnSpanFull()
         ]);
   }
}

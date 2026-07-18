<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class UserInfolist
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([
            Section::make('Informações do usuário')
               ->columnSpanFull()
               ->schema([
                  Grid::make()
                     ->columns(2)
                     ->schema([
                        TextEntry::make('name')
                           ->label('Nome')
                           ->weight(FontWeight::Bold),

                        TextEntry::make('email')
                           ->label('Email')
                           ->weight(FontWeight::Bold),

                        TextEntry::make('role')
                           ->label('Função')
                           ->weight(FontWeight::Bold),

                        TextEntry::make('email_verified_at')
                           ->label('Email verificado em')
                           ->since()
                           ->weight(FontWeight::Bold),

                        TextEntry::make('created_at')
                           ->label('Criado em')
                           ->since()
                           ->weight(FontWeight::Bold),

                        TextEntry::make('updated_at')
                           ->label('Atualizado em')
                           ->since()
                           ->weight(FontWeight::Bold),
                     ])
               ])
         ]);
   }
}

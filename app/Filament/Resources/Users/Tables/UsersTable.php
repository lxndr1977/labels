<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
   public static function configure(Table $table): Table
   {
      return $table
         ->heading('Usuários')
         ->description('Gerencie os usuários do sistema e permissõoes')
         ->defaultSort('name')
         ->columns([
            TextColumn::make('name')
               ->label('Nome')
               ->searchable()
               ->sortable(),

            TextColumn::make('email')
               ->label('Email')
               ->searchable(),

            TextColumn::make('role')
               ->label('Função'),

            TextColumn::make('email_verified_at')
               ->label('Email verificado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('created_at')
               ->label('Criado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
               ->label('Atualizado em')
               ->dateTime()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),
         ])
         ->filters([
            //
         ])
         ->recordActions([
            ActionGroup::make([
               EditAction::make(),
               DeleteAction::make(),
            ])
         ])
         ->toolbarActions([]);
   }
}

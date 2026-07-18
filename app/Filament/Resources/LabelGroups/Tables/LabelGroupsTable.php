<?php

namespace App\Filament\Resources\LabelGroups\Tables;

use App\Models\LabelGroup;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Notification;

class LabelGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->heading('Grupos de Etiquetas')
         ->description('Gerencie os grupos de etiquetas')
         ->defaultSort('name')
         ->columns([
            ImageColumn::make('image')
               ->label('Imagem'),

            TextColumn::make('name')
               ->label('Nome do Grupo de Etiquetas')
               ->searchable()
               ->sortable()
               ->grow(),

            TextColumn::make('created_at')
               ->label('Criado')
               ->since()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('updated_at')
               ->label('Atualizado')
               ->since()
               ->sortable()
               ->toggleable(isToggledHiddenByDefault: true),
         ])
         ->filters([
            //
         ])
         ->recordActions([

            ActionGroup::make([
               ViewAction::make()
                  ->icon(Heroicon::OutlinedDocumentText)
                  ->color('gray'),

               EditAction::make()
                  ->icon(Heroicon::OutlinedPencilSquare)
                  ->color('gray'),

               DeleteAction::make()
                  ->icon(Heroicon::OutlinedTrash)
                  ->before(function (DeleteAction $action, LabelGroup $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('O grupo de etiquetas possui produtos relacionados e não pode ser excluído.')
                           ->persistent()
                           ->send();

                        $action->cancel();
                     }
                  }),
            ])
               ->link()
               ->label('Ações')
               ->icon(Heroicon::Bars3BottomRight)
               ->size(Size::Small)
         ])
         ->toolbarActions([
            BulkActionGroup::make([
               DeleteBulkAction::make(),
            ]),
         ]);
    }
}

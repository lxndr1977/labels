<?php

namespace App\Filament\Resources\Packages\Tables;

use App\Models\Package;
use App\Models\Product;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\Size;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\Products\ProductResource;

class PackageTable
{
   public static function configure(Table $table): Table
   {
      return $table
         ->heading('Embalagens')
         ->description('Gerencie as embalagens dos produtos.')
         ->defaultSort('description')
         ->columns([
            ImageColumn::make('image')
               ->label('Embalagem')
               ->disk('public'),

            TextColumn::make('description')
               ->sortable()
               ->searchable()
               ->label('Descrição'),

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
         ->filters([])
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
                  ->before(function (DeleteAction $action, Package $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('A embalagem possui produtos relacionados e não pode ser excluída.')
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
         ->toolbarActions([]);
   }
}

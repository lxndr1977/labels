<?php

namespace App\Filament\Resources\Products\Tables;

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
use App\Filament\Resources\Products\ProductResource;


class ProductTable
{
   public static function configure(Table $table): Table
   {
      return $table
         ->recordTitleAttribute('comercial_name')
         ->heading('Listagem de Produtos')
         ->description('Gerencie os produtos')
         ->columns([
            TextColumn::make('comercial_name')
               ->label('Nome Comercial')
               ->sortable()
               ->searchable(),

            TextColumn::make('internal_name')
               ->label('Nome Interno')
               ->sortable()
               ->searchable(),
         ])
         ->filters([
            //
         ])
         ->recordActions([
            Action::make('print')
               ->label('Imprimir')
               ->icon('heroicon-o-printer')
               ->url(fn(Product $record): string => ProductResource::getUrl('print', ['record' => $record])),

            ActionGroup::make([
               ViewAction::make(),
               EditAction::make(),
               DeleteAction::make(),
            ])
               ->link()
               ->label('Ações')
               ->icon(Heroicon::Bars3BottomRight)
               ->size(Size::Small)
         ])
         ->toolbarActions([])
         ->searchOnBlur(true);
   }
}

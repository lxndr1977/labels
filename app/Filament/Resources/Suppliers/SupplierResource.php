<?php

namespace App\Filament\Resources\Suppliers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Support\Enums\Size;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SupplierResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Suppliers\Pages\ManageSuppliers;
use App\Filament\Resources\SupplierResource\RelationManagers;

class SupplierResource extends Resource
{
   protected static ?string $model = Supplier::class;

   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Fornecedor';

   protected static ?string $pluralModelLabel = 'Fornecedores';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'fornecedores';

   public static function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextInput::make('company_name')
               ->label('Nome do Fornecedor')
               ->columnSpanFull()
               ->required()
               ->maxLength(255),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->heading('Fornecedores')
         ->description('Gerencie os fornecedores de insumos e produtos')
         ->defaultSort('company_name')
         ->columns([
            TextColumn::make('company_name')
               ->label('Nome do Fornecedor')
               ->searchable()
               ->sortable(),

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
                  ->before(function (DeleteAction $action, Supplier $record) {
                     if ($record->batches()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('O fornecedor possui lotes de produtos relacionados e não pode ser excluído.')
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

   public static function getPages(): array
   {
      return [
         'index' => ManageSuppliers::route('/'),
      ];
   }
}

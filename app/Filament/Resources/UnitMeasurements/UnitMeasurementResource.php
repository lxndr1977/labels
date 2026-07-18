<?php

namespace App\Filament\Resources\UnitMeasurements;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\UnitMeasurement;
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
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitMeasurementResource\Pages;
use App\Filament\Resources\UnitMeasurementResource\RelationManagers;
use App\Filament\Resources\UnitMeasurements\Pages\ManageUnitMeasurements;

class UnitMeasurementResource extends Resource
{
   protected static ?string $model = UnitMeasurement::class;

   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Unidade de Medida';

   protected static ?string $pluralModelLabel = 'Unidades de Medida';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'unidades-de-medida';

   public static function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextInput::make('unit_name')
               ->label('Nome da unidade de medida')
               ->required()
               ->maxLength(255),

            TextInput::make('unit_symbol')
               ->label('Símbolo da unidade de nedida')
               ->required()
               ->maxLength(10),
         ]);
   }

   public static function infolist(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextEntry::make('unit_name')
               ->label('Número da classe'),

            TextEntry::make('unit_symbol')
               ->label('Descrição da classe'),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->recordTitleAttribute('unit_name')
         ->heading('Unidades de Medida')
         ->description('Gerencie as unidades de medida')
         ->defaultSort('unit_name')
         ->columns([
            TextColumn::make('unit_name')
               ->label('Nome da unidade')
               ->searchable()
               ->sortable(),

            TextColumn::make('unit_symbol')
               ->label('Símbolo da unidade')
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
                  ->before(function (DeleteAction $action, UnitMeasurement $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('A unidade de medida possui produtos relacionados e não pode ser excluída')
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
         'index' => ManageUnitMeasurements::route('/'),
      ];
   }
}

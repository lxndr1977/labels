<?php

namespace App\Filament\Resources\Pictograms;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pictogram;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PictogramResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Pictograms\Pages\ManagePictograms;
use App\Filament\Resources\PictogramResource\RelationManagers;

class PictogramResource extends Resource
{
   protected static ?string $model = Pictogram::class;


   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Pictograma';

   protected static ?string $pluralModelLabel = 'Pictogramas';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'pictogramas';

   public static function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextInput::make('description')
               ->label('Descrição do Pictograma')
               ->required()
               ->maxLength(255),

            FileUpload::make('image')
               ->label('Imagem do Pictograma')
               ->required()
               ->disk('public')
               ->image(),
         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->heading('Pictogramas')
         ->description('Gerencie os pictogramas para os rótulos')
         ->defaultSort('description')
         ->columns([
            ImageColumn::make('image')
               ->label('Pictograma')
               ->disk('public'),

            TextColumn::make('description')
               ->label('Descrição do Pictograma')
               ->grow()
               ->searchable()
               ->sortable(),
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
                  ->before(function (DeleteAction $action, Pictogram $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('O pictograma possui produtos relacionados e não pode ser excluído.')
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

   public static function getPages(): array
   {
      return [
         'index' => ManagePictograms::route('/'),
      ];
   }
}

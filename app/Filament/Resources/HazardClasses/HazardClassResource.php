<?php

namespace App\Filament\Resources\HazardClasses;

use BackedEnum;
use Filament\Tables\Table;
use App\Models\HazardClass;
use Filament\Actions\Action;
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
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\HazardClasses\Pages\ManageHazardClasses;

class HazardClassResource extends Resource
{
   protected static ?string $model = HazardClass::class;

   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Classe de Risco';

   protected static ?string $pluralModelLabel = 'Classes de Risco';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'classes-de-risco';

   protected static ?string $recordTitleAttribute = 'class_number';

   public static function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextInput::make('class_number')
               ->label('Número da classe')
               ->required(),

            TextInput::make('class_description')
               ->label('Descrição da classe')
               ->required(),

            TextInput::make('division_number')
               ->label('Número da divisão')
               ->default(null),

            TextInput::make('division_description')
               ->label('Descrição da divisão')
               ->default(null),
         ]);
   }

   public static function infolist(Schema $schema): Schema
   {
      return $schema
         ->components([
            TextEntry::make('class_number')
               ->label('Número da classe'),

            TextEntry::make('class_description')
               ->label('Descrição da classe'),

            TextEntry::make('division_number')
               ->label('Número da divisão')
               ->placeholder('Não informado'),

            TextEntry::make('division_description')
               ->label('Descrição da divisão')
               ->placeholder('Não informado'),

            TextEntry::make('created_at')
               ->label('Criado')
               ->since()
               ->placeholder('-'),

            TextEntry::make('updated_at')
               ->label('Atualizado')
               ->since()
               ->placeholder('-'),

         ]);
   }

   public static function table(Table $table): Table
   {
      return $table
         ->recordTitleAttribute('class_number')
         ->heading('Classes de Risco')
         ->description('Gerencie as classes de risco')
         ->defaultSort('class_number')
         ->columns([
            TextColumn::make('class_number')
               ->label('Número da classe')
               ->searchable()
               ->sortable(),

            TextColumn::make('class_description')
               ->label('Descrição da Classe')
               ->searchable(),

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
                  ->before(function (DeleteAction $action, HazardClass $record) {
                     if ($record->products()->exists()) {
                        Notification::make()
                           ->danger()
                           ->title('A exclusão falhou!')
                           ->body('A classe de risco possui produtos relacionados e não pode ser excluída.')
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
         'index' => ManageHazardClasses::route('/'),
      ];
   }
}

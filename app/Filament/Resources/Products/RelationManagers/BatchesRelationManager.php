<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class BatchesRelationManager extends RelationManager
{
   protected static string $relationship = 'batches';

   protected static ?string $title = 'Lotes';

   protected static ?string $label = 'Lote';

   protected static ?string $modelLabel = 'Lote';

   protected static ?string $pluralLabel = 'Lotes';

   protected static ?string $pluralModelLabel = 'Lotes';

   public function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            Select::make('supplier_id')
               ->label('Fornecedor')
               ->relationship('supplier', 'company_name')
               ->required(),

            TextInput::make('identification')
               ->label('Identificação')
               ->required()
               ->maxLength(255),

            TextInput::make('expiration_month')
               ->label('Mês de Validade')
               ->required()
               ->maxLength(2),

            TextInput::make('expiration_year')
               ->label('Ano de Validade')
               ->required()
               ->maxLength(4),
         ]);
   }

   public function table(Table $table): Table
   {
      return $table
         ->recordTitleAttribute('identification')
         ->columns([
            TextColumn::make('supplier.company_name')
               ->label('Fornecedor'),

            TextColumn::make('identification')
               ->label('Identificação'),

            TextColumn::make('expiration_month')
               ->label('Mês de Validade'),

            TextColumn::make('expiration_year')
               ->label('Ano de Validade'),
         ])
         ->filters([
            //
         ])
         ->headerActions([
            CreateAction::make(),
         ])
         ->recordActions([
            EditAction::make(),
            DeleteAction::make(),
         ])
         ->toolbarActions([
            BulkActionGroup::make([
               DeleteBulkAction::make(),
            ]),
         ]);
   }

   public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
   {
      return Tab::make('Lotes')
         ->icon('heroicon-o-squares-2x2');
   }
}

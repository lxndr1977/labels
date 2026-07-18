<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use App\Models\Product;
use App\Models\LabelGroup;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use App\Models\ProductVariation;
use Filament\Actions\EditAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Select;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Forms\Components\SelectPackages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\RelationManagers\RelationManager;

class VariationsRelationManager extends RelationManager
{
   protected static string $relationship = 'variations';

   protected static ?string $title = 'Variações de peso';

   protected static ?string $label = 'Variações';

   protected static ?string $modelLabel = 'Variações';

   protected static ?string $pluralLabel = 'Variações de peso';

   protected static ?string $pluralModelLabel = 'Variações de peso';

   public static function getTabComponent(Model $ownerRecord, string $pageClass): Tab
   {
      return Tab::make('Variações de Peso')
         ->icon('heroicon-o-square-3-stack-3d');
   }

   public function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            // SelectPackages::make('package_id')
            //     ->label('Embalagem')
            //     ->required(),

            Select::make('package_id')
               ->label('Embalagem')
               ->relationship('package', 'description')
               ->required()
               ->native(false)
               ->selectablePlaceholder(false)
               ->allowHtml() // Permite HTML nas opções
               ->options(
                  Package::all()->mapWithKeys(function ($pack) {
                     return [
                        $pack->id => "<div style='display: flex; align-items: center;'>
                                                <img src='" . Storage::url($pack->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                                <span>" . $pack->description . "</span>
                                            </div>"
                     ];
                  })->toArray()
               ),

            Select::make('label_group_id')
               ->label('Rótulo')
               ->relationship('labelGroup', 'name')
               ->required()
               ->native(false)
               ->selectablePlaceholder(false)
               ->allowHtml() // Permite HTML nas opções
               ->options(
                  LabelGroup::all()->mapWithKeys(function ($label) {
                     return [
                        $label->id => "<div style='display: flex; align-items: center;'>
                                                <img src='" . Storage::url($label->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                                <span>" . $label->name . "</span>
                                            </div>"
                     ];
                  })->toArray()
               ),



            TextInput::make('weight')
               ->label('Peso')
               ->numeric()
               ->inputMode('decimal'),

            Select::make('unit_measurement_id')
               ->label('Unidade de Medida')
               ->relationship('unitMeasurement', 'unit_symbol')
               ->required(),


            TextInput::make('gtin')
               ->label('GTIN - Número do Código de Barras')
               ->mask('9999999999999')
               ->maxLength(13),
         ]);
   }

   public function table(Table $table): Table
   {
      return $table
         ->recordTitleAttribute('name')
         ->columns([
            TextColumn::make('weight')
               ->label('Peso')
               ->formatStateUsing(fn($record) => $record->formattedWeight() . ' ' . $record->unitMeasurement->unit_symbol),

            TextColumn::make('gtin')
               ->label('Código de Barras'),
         ])
         ->filters([
            //
         ])
         ->headerActions([
            CreateAction::make(),
         ])
         ->recordActions([
            // Tables\Actions\Action::make('print')
            //     ->label('Imprimir')
            //     ->icon('heroicon-o-printer')
            //     ->url(fn (ProductVariation $record): string => ProductResource::getUrl('print', ['record' => $record])),  

            EditAction::make(),

            DeleteAction::make(),
         ])
         ->toolbarActions([
            BulkActionGroup::make([
               DeleteBulkAction::make(),
            ]),
         ]);
   }
}

<?php

namespace App\Filament\Resources\Products;

use App\Models\Product;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use App\Filament\Resources\Products\Pages\PrintLabel;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ViewProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Schemas\ProductForm;
use App\Filament\Resources\Products\Tables\ProductTable;
use App\Filament\Resources\Products\Schemas\ProductInfolist;
use App\Filament\Resources\Products\RelationManagers\BatchesRelationManager;
use App\Filament\Resources\Products\RelationManagers\VariationsRelationManager;

class ProductResource extends Resource
{
   protected static ?string $model = Product::class;

   protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cube';

   protected static ?string $recordTitleAttribute = 'comercial_name';

   protected static ?string $modelLabel = 'Produto';

   protected static ?string $pluralModelLabel = 'Produtos';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'produtos';

   public static function form(Schema $schema): Schema
   {
      return ProductForm::configure($schema);
   }

   public static function table(Table $table): Table
   {
     return ProductTable::configure($table);
   }

   public static function infolist(Schema $schema): Schema
   {
      return ProductInfolist::configure($schema);
   }

   public static function getRelations(): array
   {
      return [
         BatchesRelationManager::class,
         VariationsRelationManager::class,
      ];
   }

   public static function getPages(): array
   {
      return [
         'index' => ListProducts::route('/'),
         'create' => CreateProduct::route('/create'),
         'view' => ViewProduct::route('/{record}'),
         'edit' => EditProduct::route('/{record}/edit'),
         'print' => PrintLabel::route('/{record}/imprimir-etiqueta'),
      ];
   }

}

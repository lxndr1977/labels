<?php

namespace App\Filament\Resources\Packages;

use Filament\Forms;
use Filament\Tables;
use App\Models\Package;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PackageResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Packages\Tables\PackageTable;
use App\Filament\Resources\Packages\Pages\ManagePackages;
use App\Filament\Resources\PackageResource\RelationManagers;

class PackageResource extends Resource
{
   protected static ?string $model = Package::class;

   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Embalagem';

   protected static ?string $pluralModelLabel = 'Embalagens';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'embalagens';

   public static function form(Schema $schema): Schema
   {
      return $schema
         ->components([
            FileUpload::make('image')
               ->label('Imagem da Embalagem')
               ->image()
               ->required(),

            TextInput::make('description')
               ->label('Descrição'),
         ]);
   }

   public static function table(Table $table): Table
   {
     return PackageTable::configure($table);
   }

   public static function getPages(): array
   {
      return [
         'index' => ManagePackages::route('/'),
      ];
   }
}

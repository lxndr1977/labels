<?php

namespace App\Filament\Resources\LabelGroups;

use App\Filament\Resources\LabelGroups\Pages\CreateLabelGroup;
use App\Filament\Resources\LabelGroups\Pages\EditLabelGroup;
use App\Filament\Resources\LabelGroups\Pages\ListLabelGroups;
use App\Filament\Resources\LabelGroups\Pages\ViewLabelGroup;
use App\Filament\Resources\LabelGroups\Schemas\LabelGroupForm;
use App\Filament\Resources\LabelGroups\Schemas\LabelGroupInfolist;
use App\Filament\Resources\LabelGroups\Tables\LabelGroupsTable;
use App\Models\LabelGroup;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LabelGroupResource extends Resource
{
   protected static ?string $model = LabelGroup::class;

   protected static string | \UnitEnum | null $navigationGroup = 'Configurações';

   protected static ?string $modelLabel = 'Grupo de Etiqueta';

   protected static ?string $pluralModelLabel = 'Grupos de Etiquetas';

   protected static bool $hasTitleCaseModelLabel = false;

   protected static ?string $slug = 'grupos-de-etiquetas';

   protected static ?string $recordTitleAttribute = 'name';

   public static function form(Schema $schema): Schema
   {
      return LabelGroupForm::configure($schema);
   }

   public static function infolist(Schema $schema): Schema
   {
      return LabelGroupInfolist::configure($schema);
   }

   public static function table(Table $table): Table
   {
      return LabelGroupsTable::configure($table);
   }

   public static function getRelations(): array
   {
      return [
         //
      ];
   }

   public static function getPages(): array
   {
      return [
         'index' => ListLabelGroups::route('/'),
         'create' => CreateLabelGroup::route('/create'),
         'view' => ViewLabelGroup::route('/{record}'),
         'edit' => EditLabelGroup::route('/{record}/edit'),
      ];
   }
}

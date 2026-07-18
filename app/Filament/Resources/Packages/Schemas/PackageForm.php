<?php

namespace App\Filament\Resources\Packages\Schemas;

use App\Models\Pictogram;
use App\Models\HazardClass;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PackageForm
{
   public static function configure(Schema $schema): Schema
   {
      return PackageForm::configure($schema);
   }
}

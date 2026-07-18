<?php

namespace App\Filament\Resources\UnitMeasurements\Pages;

use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\UnitMeasurements\UnitMeasurementResource;

class ManageUnitMeasurements extends ManageRecords
{
   protected static string $resource = UnitMeasurementResource::class;

   protected function getHeaderActions(): array
   {
      return [
         CreateAction::make()
            ->icon(Heroicon::Plus),
      ];
   }
}

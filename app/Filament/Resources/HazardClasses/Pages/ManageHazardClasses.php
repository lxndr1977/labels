<?php

namespace App\Filament\Resources\HazardClasses\Pages;

use App\Filament\Resources\HazardClasses\HazardClassResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageHazardClasses extends ManageRecords
{
    protected static string $resource = HazardClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
               ->icon(Heroicon::Plus)
        ];
    }
}

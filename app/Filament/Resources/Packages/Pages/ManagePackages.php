<?php

namespace App\Filament\Resources\Packages\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Packages\PackageResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManagePackages extends ManageRecords
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
               ->icon(Heroicon::OutlinedPlus),
        ];
    }
}

<?php

namespace App\Filament\Resources\Pictograms\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\Pictograms\PictogramResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePictograms extends ManageRecords
{
    protected static string $resource = PictogramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\LabelGroups\Pages;

use App\Filament\Resources\LabelGroups\LabelGroupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLabelGroups extends ListRecords
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

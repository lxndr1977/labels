<?php

namespace App\Filament\Resources\LabelGroups\Pages;

use App\Filament\Resources\LabelGroups\LabelGroupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLabelGroup extends ViewRecord
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

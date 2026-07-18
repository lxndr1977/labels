<?php

namespace App\Filament\Resources\LabelGroups\Pages;

use App\Filament\Resources\LabelGroups\LabelGroupResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLabelGroup extends EditRecord
{
    protected static string $resource = LabelGroupResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

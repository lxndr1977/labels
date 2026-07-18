<?php

namespace App\Filament\Resources\Suppliers\Pages;

use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Support\Icons\Heroicon;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\Suppliers\SupplierResource;

class ManageSuppliers extends ManageRecords
{
    protected static string $resource = SupplierResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
               ->icon(Heroicon::Plus),
        ];
    }
}

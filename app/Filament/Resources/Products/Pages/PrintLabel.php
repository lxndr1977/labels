<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;


class PrintLabel extends Page
{
    use InteractsWithRecord;
    
    protected static string $resource = ProductResource::class;

    protected string $view = 'filament.resources.product-resource.pages.print-label'; 

    protected static ?string $title = 'Imprimir Etiqueta';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}

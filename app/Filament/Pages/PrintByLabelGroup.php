<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use UnitEnum;

class PrintByLabelGroup extends Page
{
   // protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-printer';
    
    protected string $view = 'filament.pages.print-by-label-group';
    
   protected static string | UnitEnum | null $navigationGroup = 'Impressão';
    
    protected static ?string $title = 'Impressão por Grupo';
    
    protected static ?string $navigationLabel = 'Por Grupo de Etiquetas';
    
    protected static ?int $navigationSort = 2;

    public function getTitle(): string
    {
        return 'Impressão por Grupo de Etiquetas';
    }

    public function getHeading(): string
    {
        return 'Impressão por Grupo de Etiquetas';
    }

    public static function canAccess(): bool
    {
        // Adicione aqui sua lógica de autorização se necessário
        return true;
    }
}
<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use App\Filament\Resources\Products\RelationManagers\BatchesRelationManager;
use App\Filament\Resources\Products\RelationManagers\VariationsRelationManager;

class ProductInfolist
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([

            Section::make('Identificação do Praaaaaaaaaaoduto')
               ->schema([
                  TextEntry::make('comercial_name')
                     ->label('Nome Comercial'),

                  TextEntry::make('label_name')
                     ->label('Nome para Impressão no Rótulo'),

                  TextEntry::make('internal_name')
                     ->label('Nome de Uso Interno'),

                  IconEntry::make('is_active')
                     ->label('Ativo?')
                     ->boolean(),
               ]),

            Section::make('Propriedades')
               ->schema([
                  TextEntry::make('cure')->label('Tipo de Cura'),
                  TextEntry::make('viscosity')->label('Viscosidade'),
                  TextEntry::make('thickness')->label('Espessura'),
               ])->columns(3),

            Section::make('Informações Técnicas')
               ->schema([
                  TextEntry::make('chemycal_type')->label('Tipo Químico')->columnSpanFull(),
                  TextEntry::make('liquid_substance')->label('Substância Líquida')->columnSpanFull(),
                  TextEntry::make('technical_features')->label('Características Técnicas')->columnSpanFull(),
               ]),

            Section::make('Identificação e Riscos')
               ->schema([
                  TextEntry::make('un_number')->label('Número ONU'),
                  TextEntry::make('hazardClass.class_number')->label('Classe de Risco'),
               ])->columns(2),

            Section::make('Pictogramas')
               ->schema([
                  TextEntry::make('pictograms.description')->label('Pictogramas'),
                  ImageEntry::make('pictograms.image')->label('Ícones')->square(),
               ]),

            Section::make('Outras Informações')
               ->schema([
                  TextEntry::make('proportion')->label('Proporção de Mistura ou Shore'),
                  TextEntry::make('description')->label('Informações de uso interno')->markdown(),
               ]),
         ])->columns(1);
   }
}

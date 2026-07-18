<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Pictogram;
use App\Models\HazardClass;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ProductForm
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([
            Section::make('Identificação do Produto')
               ->schema([
                  TextInput::make('comercial_name')
                     ->label('Nome Comercial')
                     ->required()
                     ->maxLength(255),

                  TextInput::make('label_name')
                     ->label('Nome para Impressão no Rótulo')
                     ->required()
                     ->maxLength(25),

                  TextInput::make('internal_name')
                     ->label('Nome de Uso Interno')
                     ->maxLength(255),

                  Toggle::make('is_active')
                     ->label('Ativo?'),

               ]),

            Section::make('Propriedades')
               ->schema([
                  Select::make('cure')
                     ->label('Tipo de Cura')
                     ->options([
                        'na' => 'Não se aplica',
                        'lenta' => 'Lenta',
                        'rapida' => 'Rápida',
                     ])
                     ->required(),

                  Select::make('viscosity')
                     ->label('Viscosidade')
                     ->options([
                        'na' => 'Não se aplica',
                        'baixa' => 'Baixa',
                        'media' => 'Média',
                        'alta' => 'Alta',
                     ])
                     ->required(),

                  Select::make('thickness')
                     ->label('Espessura')
                     ->options([
                        'na' => 'Não se aplica',
                        'alta' => 'Alta',
                        'baixa' => 'Baixa',
                     ])
                     ->required(),
               ])->columns(3),

            Section::make('Informacões Técnicas')
               ->schema([
                  TextInput::make('chemycal_type')
                     ->label('Tipo Químico')
                     ->columnSpanFull()
                     ->maxLength(255),

                  TextInput::make('liquid_substance')
                     ->label('Substância Líquida')
                     ->columnSpanFull()
                     ->maxLength(255),

                  TextInput::make('technical_features')
                     ->label('Características Técnicas')
                     ->columnSpanFull()
                     ->maxLength(255),
               ]),

            Section::make('Identificação e Riscos')
               ->schema([
                  TextInput::make('un_number')
                     ->label('Número ONU')
                     ->maxLength(255),

                  Select::make('hazard_class_id')
                     ->label('Classe de Risco')
                     ->options(HazardClass::pluck('class_number', 'id'))
                     ->required()
               ])->columns(2),

            Section::make('Pictogramas')
               ->schema([
                  Select::make('pictograms')
                     ->label('Pictogramas')
                     ->relationship('pictograms', 'description')
                     ->native(false)
                     ->multiple()
                     ->allowHtml()
                     ->options(
                        Pictogram::all()->mapWithKeys(function ($pictogram) {
                           return [
                              $pictogram->id =>
                              "<div style='display: flex; align-items: center;'>
                                 <img src='" . Storage::url($pictogram->image) . "' style='width: 40px; height: 40px; margin-right: 10px;'/>
                                 <span>" . $pictogram->description . "</span>
                              </div>"
                           ];
                        })->toArray()
                     ),
               ]),

            Section::make('Outras Informações')
               ->schema([
                  TextInput::make('proportion')
                     ->label('Proporção de Mistura ou Shore')
                     ->maxLength(50),

                  Textarea::make('description')
                     ->label('Informações de uso interno')
                     ->rows(10)
                     ->cols(20),
               ]),
         ])->columns(1);
   }
}

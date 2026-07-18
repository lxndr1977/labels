<?php

namespace App\Filament\Resources\LabelGroups\Schemas;

use Filament\Schemas\Schema;
use App\Enums\TextAlignmentEnum;
use App\Enums\OrientationPageEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class LabelGroupForm
{
   public static function configure(Schema $schema): Schema
   {
      return $schema
         ->components([
            Section::make('Configurações Gerais')
               ->columnSpanFull()
               ->schema([
                  TextInput::make('name')
                     ->label('Nome do Grupo de Etiquetas')
                     ->required()
                     ->maxLength(255),

                  FileUpload::make('image')
                     ->label('Imagem da Etiqueta')
                     ->image()
                     ->required(),

                  Select::make('page_size')
                     ->label('Tamanho da Página')
                     ->options(OrientationPageEnum::class)
                     ->required(),

                  Select::make('page_orientation')
                     ->label('Orientação da Página')
                     ->options(OrientationPageEnum::class)
                     ->required(),
               ]),

            Section::make('Margens da Página')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('page_margin_top')
                     ->label('Superior (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('page_margin_right')
                     ->label('Direita (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('page_margin_bottom')
                     ->label('Inferior (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('page_margin_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),
               ]),

            Section::make('Configurações do Rótulo')
               ->columnSpanFull()
               ->columns(4)
               ->schema([

                  TextInput::make('printing_area_width')
                     ->label('Largura da Área de Impressão (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('printing_area_height')
                     ->label('Altura da Área de Impressão (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('label_width')
                     ->label('Largura do Rótulo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('label_height')
                     ->label('Altura do Rótulo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('labels_per_row')
                     ->label('Etiquetas por Linha')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('labels_per_page')
                     ->label('Etiquetas por Página')
                     ->numeric()
                     ->required(),

                  TextInput::make('labels_row_gap')
                     ->label('Espaçamento entre Linhas (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('labels_column_gap')
                     ->label('Espaçamento entre Colunas (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),
               ]),

            Section::make('Configurações do Nome do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_name_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_name_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_name_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_name_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_name_text_align')
                     ->label('Alinhamento do Texto')
                     ->options(TextAlignmentEnum::class)
                     ->required(),

                  TextInput::make('product_name_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),
               ]),

            Section::make('Configurações das Propriedades do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_properties_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_properties_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_property_cure_top')
                     ->label('Cura - Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_property_viscosity_top')
                     ->label('Viscosidade - Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_property_thickness_top')
                     ->label('Espessura - Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_property_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_property_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_properties_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),
               ]),

            Section::make('Configurações das Informações do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_info_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_info_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_info_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_info_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),

                  TextInput::make('product_info_line_height')
                     ->label('Altura da Linha')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_info_padding')
                     ->label('Preenchimento (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_info_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),
               ]),

            Section::make('Configurações do Lote do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_batch_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_batch_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_batch_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_batch_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_batch_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),

                  Select::make('product_batch_text_align')
                     ->label('Alinhamento do Texto')
                     ->options(TextAlignmentEnum::class)

                     ->required(),

                  TextInput::make('product_batch_padding')
                     ->label('Preenchimento (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_batch_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),
               ]),

            Section::make('Configurações do Código de Barras')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_barcode_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_barcode_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_barcode_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_barcode_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_barcode_padding')
                     ->label('Preenchimento (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),
               ]),

            Section::make('Configurações dos Pictogramas do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_pictograms_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_pictograms_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_pictograms_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_pictograms_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_pictograms_padding')
                     ->label('Preenchimento (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_pictograms_image_width')
                     ->label('Largura do Pictograma (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_pictograms_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),

                  TextInput::make('product_pictograms_gap')
                     ->label('Espaçamento(cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),
               ]),

            Section::make('Configurações do Peso do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_weight_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_weight_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_weight_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_weight_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_weight_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),

                  Select::make('product_weight_text_align')
                     ->label('Alinhamento do Texto')
                     ->options(TextAlignmentEnum::class)
                     ->required(),
               ]),

            Section::make('Configurações da Proporção do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('proportion_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('proportion_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('proportion_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('proportion_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('proportion_text_align')
                     ->label('Alinhamento')
                     ->options(TextAlignmentEnum::class)

                     ->required(),

                  TextInput::make('proportion_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),

                  Select::make('proportion_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),
               ]),

            Section::make('Configurações da Descrição do Produto')
               ->columnSpanFull()
               ->columns(4)
               ->schema([
                  TextInput::make('product_description_top')
                     ->label('Topo (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_description_left')
                     ->label('Esquerda (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_description_width')
                     ->label('Largura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  TextInput::make('product_description_height')
                     ->label('Altura (cm)')
                     ->numeric()
                     ->inputMode('decimal')
                     ->required(),

                  Select::make('product_description_text_align')
                     ->label('Alinhamento do Texto')
                     ->options(TextAlignmentEnum::class)
                     ->required(),

                  TextInput::make('product_description_font_size')
                     ->label('Tamanho da Fonte')
                     ->required(),

                  Select::make('product_description_visibility')
                     ->label('Visibilidade')
                     ->options([
                        'visible' => 'Visível',
                        'hidden' => 'Oculto',
                     ])
                     ->required(),
               ]),
         ]);
   }
}

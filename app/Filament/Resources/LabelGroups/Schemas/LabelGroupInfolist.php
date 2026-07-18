<?php

namespace App\Filament\Resources\LabelGroups\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class LabelGroupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make('Configurações Gerais')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')->label('Nome do Grupo de Etiquetas'),

                        ImageEntry::make('image')->label('Imagem da Etiqueta'),

                        TextEntry::make('page_size')
                            ->label('Tamanho da Página'),

                        TextEntry::make('page_orientation')
                            ->label('Orientação da Página'),
                    ])
                    ->columnSpanFull(),

                Section::make('Margens da Página')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('page_margin_top')->label('Superior (cm)'),
                        TextEntry::make('page_margin_right')->label('Direita (cm)'),
                        TextEntry::make('page_margin_bottom')->label('Inferior (cm)'),
                        TextEntry::make('page_margin_left')->label('Esquerda (cm)'),
                    ])
                    ->columnSpanFull(),
                    
                Section::make('Configurações do Rótulo')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('printing_area_width')->label('Largura da Área de Impressão (cm)'),
                        TextEntry::make('printing_area_height')->label('Altura da Área de Impressão (cm)'),
                        TextEntry::make('label_width')->label('Largura do Rótulo (cm)'),
                        TextEntry::make('label_height')->label('Altura do Rótulo (cm)'),
                        TextEntry::make('labels_per_row')->label('Etiquetas por Linha'),
                        TextEntry::make('labels_per_page')->label('Etiquetas por Página'),
                        TextEntry::make('labels_row_gap')->label('Espaçamento entre Linhas (cm)'),
                        TextEntry::make('labels_column_gap')->label('Espaçamento entre Colunas (cm)'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações do Nome do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_name_top')->label('Topo (cm)'),
                        TextEntry::make('product_name_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_name_width')->label('Largura (cm)'),
                        TextEntry::make('product_name_height')->label('Altura (cm)'),
                        TextEntry::make('product_name_text_align')
                            ->label('Alinhamento do Texto'),
                        TextEntry::make('product_name_font_size')->label('Tamanho da Fonte'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações das Propriedades do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_properties_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_properties_width')->label('Largura (cm)'),
                        TextEntry::make('product_property_cure_top')->label('Cura - Topo (cm)'),
                        TextEntry::make('product_property_viscosity_top')->label('Viscosidade - Topo (cm)'),
                        TextEntry::make('product_property_thickness_top')->label('Espessura - Topo (cm)'),
                        TextEntry::make('product_property_width')->label('Largura (cm)'),
                        TextEntry::make('product_property_height')->label('Altura (cm)'),
                        TextEntry::make('product_properties_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações das Informações do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_info_top')->label('Topo (cm)'),
                        TextEntry::make('product_info_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_info_width')->label('Largura (cm)'),
                        TextEntry::make('product_info_font_size')->label('Tamanho da Fonte'),
                        TextEntry::make('product_info_line_height')->label('Altura da Linha'),
                        TextEntry::make('product_info_padding')->label('Preenchimento (cm)'),
                        TextEntry::make('product_info_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações do Lote do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_batch_top')->label('Topo (cm)'),
                        TextEntry::make('product_batch_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_batch_width')->label('Largura (cm)'),
                        TextEntry::make('product_batch_height')->label('Altura (cm)'),
                        TextEntry::make('product_batch_font_size')->label('Tamanho da Fonte'),
                        TextEntry::make('product_batch_text_align')
                            ->label('Alinhamento do Texto'),
                        TextEntry::make('product_batch_padding')->label('Preenchimento (cm)'),
                        TextEntry::make('product_batch_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações do Código de Barras')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_barcode_top')->label('Topo (cm)'),
                        TextEntry::make('product_barcode_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_barcode_width')->label('Largura (cm)'),
                        TextEntry::make('product_barcode_height')->label('Altura (cm)'),
                        TextEntry::make('product_barcode_padding')->label('Preenchimento (cm)'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações dos Pictogramas do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_pictograms_top')->label('Topo (cm)'),
                        TextEntry::make('product_pictograms_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_pictograms_width')->label('Largura (cm)'),
                        TextEntry::make('product_pictograms_height')->label('Altura (cm)'),
                        TextEntry::make('product_pictograms_padding')->label('Preenchimento (cm)'),
                        TextEntry::make('product_pictograms_image_width')->label('Largura do Pictograma (cm)'),
                        TextEntry::make('product_pictograms_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                        TextEntry::make('product_pictograms_gap')->label('Espaçamento (cm)'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações do Peso do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_weight_top')->label('Topo (cm)'),
                        TextEntry::make('product_weight_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_weight_width')->label('Largura (cm)'),
                        TextEntry::make('product_weight_height')->label('Altura (cm)'),
                        TextEntry::make('product_weight_font_size')->label('Tamanho da Fonte'),
                        TextEntry::make('product_weight_text_align')
                            ->label('Alinhamento do Texto')
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações da Proporção do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('proportion_top')->label('Topo (cm)'),
                        TextEntry::make('proportion_left')->label('Esquerda (cm)'),
                        TextEntry::make('proportion_width')->label('Largura (cm)'),
                        TextEntry::make('proportion_height')->label('Altura (cm)'),
                        TextEntry::make('proportion_text_align')
                            ->label('Alinhamento'),
                        TextEntry::make('proportion_font_size')->label('Tamanho da Fonte'),
                        TextEntry::make('proportion_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                    ])
                    ->columnSpanFull(),

                Section::make('Configurações da Descrição do Produto')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('product_description_top')->label('Topo (cm)'),
                        TextEntry::make('product_description_left')->label('Esquerda (cm)'),
                        TextEntry::make('product_description_width')->label('Largura (cm)'),
                        TextEntry::make('product_description_height')->label('Altura (cm)'),
                        TextEntry::make('product_description_text_align')
                            ->label('Alinhamento do Texto'),
                        TextEntry::make('product_description_font_size')->label('Tamanho da Fonte'),
                        TextEntry::make('product_description_visibility')
                            ->label('Visibilidade')
                            ->badge()
                            ->color(fn ($state) => $state === 'visible' ? 'success' : 'gray'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}

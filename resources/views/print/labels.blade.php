<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Impressão de Etiquetas - {{ $labelGroup->name }}</title>
    <style>
        @page {
            size: {{ $labelGroup->page_size ?? 'A4' }};
            orientation: {{ $labelGroup->page_orientation ?? 'portrait' }};
            margin: {{ $labelGroup->page_margin_top ?? 0 }}mm {{ $labelGroup->page_margin_right ?? 0 }}mm {{ $labelGroup->page_margin_bottom ?? 0 }}mm {{ $labelGroup->page_margin_left ?? 0 }}mm;
        }
        
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        
        .print-area {
            width: {{ $labelGroup->printing_area_width ?? 210 }}mm;
            height: {{ $labelGroup->printing_area_height ?? 297 }}mm;
            position: relative;
        }
        
        .labels-container {
            display: flex;
            flex-wrap: wrap;
            gap: {{ $labelGroup->labels_row_gap ?? 0 }}mm {{ $labelGroup->labels_column_gap ?? 0 }}mm;
        }
        
        .label {
            width: {{ $labelGroup->label_width ?? 70 }}mm;
            height: {{ $labelGroup->label_height ?? 37 }}mm;
            border: 1px dashed #ccc;
            position: relative;
            page-break-inside: avoid;
            overflow: hidden;
        }
        
        .label-content {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .product-name {
            position: absolute;
            top: {{ $labelGroup->product_name_top ?? 0 }}mm;
            left: {{ $labelGroup->product_name_left ?? 0 }}mm;
            width: {{ $labelGroup->product_name_width ?? 100 }}%;
            height: {{ $labelGroup->product_name_height ?? 'auto' }};
            text-align: {{ $labelGroup->product_name_text_align ?? 'left' }};
            font-size: {{ $labelGroup->product_name_font_size ?? 12 }}pt;
            font-weight: bold;
            overflow: hidden;
        }
        
        .product-weight {
            position: absolute;
            top: {{ $labelGroup->product_weight_top ?? 0 }}mm;
            left: {{ $labelGroup->product_weight_left ?? 0 }}mm;
            width: {{ $labelGroup->product_weight_width ?? 100 }}%;
            height: {{ $labelGroup->product_weight_height ?? 'auto' }};
            text-align: {{ $labelGroup->product_weight_text_align ?? 'left' }};
            font-size: {{ $labelGroup->product_weight_font_size ?? 10 }}pt;
            font-weight: bold;
        }
        
        .product-batch {
            position: absolute;
            top: {{ $labelGroup->product_batch_top ?? 0 }}mm;
            left: {{ $labelGroup->product_batch_left ?? 0 }}mm;
            width: {{ $labelGroup->product_batch_width ?? 100 }}%;
            height: {{ $labelGroup->product_batch_height ?? 'auto' }};
            text-align: {{ $labelGroup->product_batch_text_align ?? 'left' }};
            font-size: {{ $labelGroup->product_batch_font_size ?? 10 }}pt;
            padding: {{ $labelGroup->product_batch_padding ?? 0 }}mm;
        }
        
        .product-pictograms {
            position: absolute;
            top: {{ $labelGroup->product_pictograms_top ?? 0 }}mm;
            left: {{ $labelGroup->product_pictograms_left ?? 0 }}mm;
            width: {{ $labelGroup->product_pictograms_width ?? 100 }}%;
            height: {{ $labelGroup->product_pictograms_height ?? 'auto' }};
            display: flex;
            gap: {{ $labelGroup->product_pictograms_gap ?? 2 }}mm;
            padding: {{ $labelGroup->product_pictograms_padding ?? 0 }}mm;
        }
        
        .pictogram {
            width: {{ $labelGroup->product_pictograms_image_width ?? 10 }}mm;
            height: {{ $labelGroup->product_pictograms_image_width ?? 10 }}mm;
        }
        
        .product-info {
            position: absolute;
            top: {{ $labelGroup->product_info_top ?? 0 }}mm;
            left: {{ $labelGroup->product_info_left ?? 0 }}mm;
            width: {{ $labelGroup->product_info_width ?? 100 }}%;
            font-size: {{ $labelGroup->product_info_font_size ?? 8 }}pt;
            line-height: {{ $labelGroup->product_info_line_height ?? 1.2 }};
            padding: {{ $labelGroup->product_info_padding ?? 0 }}mm;
        }
        
        .proportion {
            position: absolute;
            top: {{ $labelGroup->proportion_top ?? 0 }}mm;
            left: {{ $labelGroup->proportion_left ?? 0 }}mm;
            width: {{ $labelGroup->proportion_width ?? 100 }}%;
            height: {{ $labelGroup->proportion_height ?? 'auto' }};
            text-align: {{ $labelGroup->proportion_text_align ?? 'left' }};
            font-size: {{ $labelGroup->proportion_font_size ?? 10 }}pt;
        }
        
        .product-description {
            position: absolute;
            top: {{ $labelGroup->product_description_top ?? 0 }}mm;
            left: {{ $labelGroup->product_description_left ?? 0 }}mm;
            width: {{ $labelGroup->product_description_width ?? 100 }}%;
            height: {{ $labelGroup->product_description_height ?? 'auto' }};
            text-align: {{ $labelGroup->product_description_text_align ?? 'left' }};
            font-size: {{ $labelGroup->product_description_font_size ?? 8 }}pt;
        }
        
        .product-barcode {
            position: absolute;
            top: {{ $labelGroup->product_barcode_top ?? 0 }}mm;
            left: {{ $labelGroup->product_barcode_left ?? 0 }}mm;
            width: {{ $labelGroup->product_barcode_width ?? 100 }}%;
            height: {{ $labelGroup->product_barcode_height ?? 10 }}mm;
            padding: {{ $labelGroup->product_barcode_padding ?? 0 }}mm;
        }
        
        .control-buttons {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .btn {
            padding: 8px 16px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="control-buttons no-print">
        <button class="btn btn-primary" onclick="window.print()">🖨️ Imprimir</button>
        <button class="btn btn-secondary" onclick="history.back()">↩️ Voltar</button>
        <span style="margin-left: 10px; font-size: 12px;">
            Total: {{ count($processedItems) }} etiquetas
        </span>
    </div>

    @if(empty($processedItems))
        <div style="text-align: center; padding: 50px; font-size: 18px; color: #666;">
            <p>Nenhuma etiqueta para imprimir.</p>
            <button class="btn btn-secondary" onclick="history.back()">← Voltar</button>
        </div>
    @else
        <div class="print-area">
            <div class="labels-container">
                @foreach($processedItems as $index => $item)
                    {{-- Quebra de página a cada conjunto de etiquetas por página --}}
                    @if($index > 0 && $index % ($labelGroup->labels_per_page ?? 12) === 0)
                        </div>
                        <div style="page-break-before: always;"></div>
                        <div class="labels-container">
                    @endif
                
                <div class="label">
                    <div class="label-content">
                        {{-- Nome do Produto --}}
                        <div class="product-name">
                            {{ $item['label_name'] }}
                        </div>
                        
                        {{-- Peso do Produto --}}
                        <div class="product-weight">
                            {{ $item['weight'] }}
                        </div>
                        
                        {{-- Informações do Lote --}}
                        @if(($labelGroup->product_batch_visibility ?? true))
                        <div class="product-batch">
                            Lote: {{ $item['batch']->identification }}<br>
                            Val: {{ $item['batch']->expiration_month }}/{{ $item['batch']->expiration_year }}
                            @if($item['supplier_name'])
                                <br>{{ $item['supplier_name'] }}
                            @endif
                        </div>
                        @endif
                        
                        {{-- Pictogramas --}}
                        @if(($labelGroup->product_pictograms_visibility ?? true) && $item['product']->pictograms && $item['product']->pictograms->count() > 0)
                        <div class="product-pictograms">
                            @foreach($item['product']->pictograms as $pictogram)
                                <img src="{{ asset('storage/' . $pictogram->image) }}" 
                                     alt="{{ $pictogram->name }}" 
                                     class="pictogram">
                            @endforeach
                        </div>
                        @endif
                        
                        {{-- Informações do Produto --}}
                        @if(($labelGroup->product_info_visibility ?? true))
                        <div class="product-info">
                            @if($item['product']->signal_word)
                                <strong>{{ $item['product']->signal_word }}</strong><br>
                            @endif
                            @if($item['product']->hazardClass)
                                Classe: {{ $item['product']->hazardClass->name }}<br>
                            @endif
                            @if($item['product']->un_number)
                                UN: {{ $item['product']->un_number }}<br>
                            @endif
                        </div>
                        @endif
                        
                        {{-- Propriedades do Produto --}}
                        @if(($labelGroup->product_properties_visibility ?? true))
                            @if($item['product']->cure)
                            <div style="position: absolute; top: {{ $labelGroup->product_property_cure_top ?? 0 }}mm; left: {{ $labelGroup->product_properties_left ?? 0 }}mm; width: {{ $labelGroup->product_property_width ?? 20 }}mm; height: {{ $labelGroup->product_property_height ?? 5 }}mm; font-size: 8pt;">
                                Cura: {{ $item['product']->cure }}
                            </div>
                            @endif
                            
                            @if($item['product']->viscosity)
                            <div style="position: absolute; top: {{ $labelGroup->product_property_viscosity_top ?? 0 }}mm; left: {{ $labelGroup->product_properties_left ?? 0 }}mm; width: {{ $labelGroup->product_property_width ?? 20 }}mm; height: {{ $labelGroup->product_property_height ?? 5 }}mm; font-size: 8pt;">
                                Visc: {{ $item['product']->viscosity }}
                            </div>
                            @endif
                            
                            @if($item['product']->thickness)
                            <div style="position: absolute; top: {{ $labelGroup->product_property_thickness_top ?? 0 }}mm; left: {{ $labelGroup->product_properties_left ?? 0 }}mm; width: {{ $labelGroup->product_property_width ?? 20 }}mm; height: {{ $labelGroup->product_property_height ?? 5 }}mm; font-size: 8pt;">
                                Esp: {{ $item['product']->thickness }}
                            </div>
                            @endif
                        @endif
                        
                        {{-- Proporção --}}
                        @if($item['product']->proportion)
                        <div class="proportion">
                            {{ $item['product']->proportion }}
                        </div>
                        @endif
                        
                        {{-- Descrição do Produto --}}
                        @if(($labelGroup->product_description_visibility ?? true) && $item['product']->technical_features)
                        <div class="product-description">
                            {{ Str::limit($item['product']->technical_features, 100) }}
                        </div>
                        @endif
                        
                        {{-- Código de Barras (se houver GTIN) --}}
                        @if($item['variation']->gtin)
                        <div class="product-barcode">
                            <div style="font-family: 'Libre Barcode 128', monospace; font-size: 24px; text-align: center;">
                                {{ $item['variation']->gtin }}
                            </div>
                            <div style="text-align: center; font-size: 8pt; margin-top: 2px;">
                                {{ $item['variation']->gtin }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    @endif

    <script>
        // Auto-print quando a página carregar (opcional)
        // window.onload = function() {
        //     setTimeout(function() {
        //         window.print();
        //     }, 1000);
        // };
        
        // Função para voltar à página anterior
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
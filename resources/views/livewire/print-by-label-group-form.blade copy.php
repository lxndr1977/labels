<div class="space-y-6 bg-red-100">

   <div class="no-print">

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Seleção do Grupo de Etiquetas --}}
    <x-filament::section>
        <x-slot name="heading">
            1. Selecione o Grupo de Etiquetas
        </x-slot>
        
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="labelGroup" class="block text-sm font-medium text-gray-700 mb-2">
                    Grupo de Etiquetas
                </label>
                <x-filament::input.wrapper>
                    <x-filament::input.select 
                        wire:model.live="selectedLabelGroupId" 
                        wire:change="selectLabelGroup"
                        id="labelGroup"
                    >
                        <option value="">Selecione um grupo de etiquetas...</option>
                        @foreach($labelGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
        </div>
    </x-filament::section>

    {{-- Campo de Pesquisa --}}
    @if($selectedLabelGroupId)
        <x-filament::section>
            <x-slot name="heading">
                Pesquisar Produto
            </x-slot>
            
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="searchProduct" class="block text-sm font-medium text-gray-700 mb-2">
                        Nome do Produto
                    </label>
                    <x-filament::input.wrapper>
                        <x-filament::input 
                            wire:model.live.debounce.300ms="searchProduct"
                            id="searchProduct"
                            type="text"
                            placeholder="Digite o nome do produto para filtrar..."
                        />
                        @if($searchProduct)
                            <x-slot name="suffix">
                                <x-filament::icon-button 
                                    wire:click="$set('searchProduct', '')"
                                    icon="heroicon-o-x-mark"
                                    size="sm"
                                    tooltip="Limpar pesquisa"
                                />
                            </x-slot>
                        @endif
                    </x-filament::input.wrapper>
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- Lista de Produtos --}}
    @if($showProducts && $availableProductVariations)
        <x-filament::section>
            <x-slot name="heading">
                2. Selecione os Produtos para Impressão
            </x-slot>
            
            <div class="space-y-4">
                @foreach($availableProductVariations as $product)
                    <x-filament::fieldset>
                        <x-slot name="label">
                            <div class="font-medium text-gray-900">
                                {{ $product['label_name'] ?? $product['comercial_name'] }}
                                {{ $product['display_name'] }}
                            </div>
                        </x-slot>

                        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">
                            {{-- Seleção de Lote --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Lote
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input.select 
                                        wire:model="selectedBatches.{{ $product['variation_id'] }}"
                                    >
                                        <option value="">Selecione...</option>
                                        @foreach($this->getBatchesForVariation($product['variation_id']) as $batch)
                                            <option value="{{ $batch->id }}">
                                                {{ $batch->identification }} 
                                                ({{ $batch->expiration_month }}/{{ $batch->expiration_year }})
                                            </option>
                                        @endforeach
                                    </x-filament::input.select>
                                </x-filament::input.wrapper>
                            </div>

                            {{-- Quantidade --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Quantidade
                                </label>
                                <x-filament::input.wrapper>
                                    <x-filament::input 
                                        type="number" 
                                        wire:model="selectedQuantities.{{ $product['variation_id'] }}"
                                        min="1"
                                    />
                                </x-filament::input.wrapper>
                            </div>

                            {{-- Botão Adicionar --}}
                            <div class="lg:col-span-2">
                                <x-filament::button 
                                    wire:click="addToQueue({{ $product['variation_id'] }})"
                                    color="primary"
                                    icon="heroicon-o-plus"
                                >
                                    Adicionar à Lista
                                </x-filament::button>
                            </div>
                        </div>
                    </x-filament::fieldset>
                @endforeach
            </div>
        </x-filament::section>
    @elseif($showProducts && count($availableProductVariations) == 0)
        <x-filament::section>
            <div class="text-center py-8">
                <div class="mx-auto w-12 h-12 text-gray-400 mb-4">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8V4a1 1 0 00-1-1H7a1 1 0 00-1 1v1m8 0V4a1 1 0 00-1-1H9a1 1 0 00-1 1v1m0 0H8m1 0h1m-1 0v1m1-1v1"></path>
                    </svg>
                </div>
                <p class="text-gray-500 text-lg">Nenhum produto encontrado para este grupo de etiquetas</p>
            </div>
        </x-filament::section>
    @endif

    {{-- Lista de Impressão --}}
    @if(!empty($printQueue))
        <x-filament::section>
            <x-slot name="heading">
                3. Lista de Impressão
            </x-slot>
            
            <x-slot name="headerEnd">
                <div class="flex flex-wrap gap-2">
                    <x-filament::button 
                        wire:click="clearQueue"
                        color="gray"
                        icon="heroicon-o-trash"
                        onclick="return confirm('Tem certeza que deseja limpar toda a lista?')"
                    >
                        Limpar Lista
                    </x-filament::button>
                    
                    <x-filament::button 
                        wire:click="previewImprinting"
                        icon="heroicon-o-eye"
                    >
                        👁️ Visualizar ({{ count($printQueue) }} itens)
                    </x-filament::button>
                    
                    <x-filament::button 
                        wire:click="processImprinting"
                        color="success"
                        icon="heroicon-o-printer"
                    >
                        🖨️ Imprimir ({{ count($printQueue) }} itens)
                    </x-filament::button>
                </div>
            </x-slot>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produto
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Peso
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lote
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Validade
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fornecedor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Qtd
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($printQueue as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item['product_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-filament::badge color="gray" size="sm">
                                        {{ $item['weight'] }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-filament::badge color="primary" size="sm">
                                        {{ $item['batch_identification'] }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['expiration'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['supplier_name'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-filament::badge color="success" size="sm">
                                        {{ $item['quantity'] }}
                                    </x-filament::badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <x-filament::icon-button 
                                        wire:click="removeFromQueue({{ $index }})"
                                        icon="heroicon-o-trash"
                                        color="danger"
                                        size="sm"
                                        tooltip="Remover item"
                                        onclick="return confirm('Remover este item da lista?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">Total de itens:</span> {{ count($printQueue) }}
                    </div>
                    <div class="text-sm text-gray-600">
                        <span class="font-semibold">Total de etiquetas:</span> 
                        <x-filament::badge color="info" size="lg">
                            {{ collect($printQueue)->sum('quantity') }}
                        </x-filament::badge>
                    </div>
                </div>
            </div>
        </x-filament::section>
    @endif

    {{-- Botão de impressão apenas quando showPrintContent for true --}}
    @if(!empty($printQueue))
        <div class="no-print">
            <button 
                type="button" 
                class="print-button fi-btn fi-btn-color-success fi-btn-size-md"
    onclick="printDiv('print-content')"
            >
                Imprimir rótulos
            </button>
        </div>
    @endif
</div>


<div x-data>
    <div id="printableArea">
{{-- Print content - só exibe quando showPrintContent for true --}}
@if(!empty($printQueue))


   <button 
        @click="
            let printContents = document.getElementById('printableArea').innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        "
        class="btn"
    >
        Imprimir
    </button>
    <div class="print-content">
        @php
            // Pegar o primeiro item da fila para definir configurações de página
            $firstItem = $printQueue[0];
            $firstVariation = \App\Models\ProductVariation::find($firstItem['variation_id']);
            $labels_per_page = $firstVariation ? $firstVariation->labelGroup->labels_per_page : 1;
            
            // Contador global de etiquetas
            $global_label_count = 0;
        @endphp

        @foreach($printQueue as $queueItem)
            @php
                $selectedVariation = \App\Models\ProductVariation::with(['product.pictograms', 'labelGroup'])->find($queueItem['variation_id']);
                $selectedBatch = \App\Models\Batch::find($queueItem['batch_id']);
                $product = $selectedVariation->product;
                $quantity = $queueItem['quantity'];
            @endphp

            {{-- Imprimir a quantidade especificada de etiquetas para este produto --}}
            @for ($label_num = 1; $label_num <= $quantity; $label_num++)
                @php $global_label_count++; @endphp
                
                {{-- Abrir nova página se necessário --}}
                @if (($global_label_count - 1) % $labels_per_page == 0)
                <div class="print-label-page">
                @endif

                {{-- Conteúdo da etiqueta aqui --}}
                <div class="print-label-container">
                    {{-- Conteúdo da etiqueta --}}
                    <div class="product-name">
                        {{ $product->label_name }}
                    </div>

                    <div class="product-info">
                        <p>ONU: {{ $product->un_number }}</p>
                        <p>Classe Risco: {{ $product->hazardClass->class_number }}</p>
                    </div>

                    <div class="product-proportion">
                        @if (!empty($product->proportion)) <p>{{ $product->proportion }}</p> @endif
                    </div>

                    <div class="product-description">
                        <p>{{ $product->label_product_description }}</p>
                    </div>

                    {{-- Product properties --}}
                    <div class="product-properties">
                        <div class="product-property cure">
                            <div>
                                <span class="{{ $product->cure == 'lenta' ? 'active' : '' }}"></span>
                            </div>
                            <div>
                                <span class="{{ $product->cure == 'rapida' ? 'active' : '' }}"></span>
                            </div>
                            <div></div>
                        </div>
                        <div class="product-property viscosity">
                            <div>
                                <span class="{{ $product->viscosity == 'baixa' ? 'active' : '' }}"></span>
                            </div>
                            <div>
                                <span class="{{ $product->viscosity == 'media' ? 'active' : '' }}"></span>
                            </div>
                            <div>
                                <span class="{{ $product->viscosity == 'alta' ? 'active' : '' }}"></span>
                            </div>
                        </div>
                        <div class="product-property thickness">
                            <div>
                                <span class="{{ $product->thickness == 'baixa' ? 'active' : '' }}"></span>
                            </div>
                            <div>
                                <span class="{{ $product->thickness == 'media' ? 'active' : '' }}"></span>
                            </div>
                            <div>
                                <span class="{{ $product->thickness == 'alta' ? 'active' : '' }}"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Product batch --}}
                    <div class="product-batch">
                        <p>Lote: {{ $selectedBatch ? $selectedBatch->identification : '' }}</p>
                        <p>Validade: {{ $selectedBatch ? $selectedBatch->expiration_month . '/' . $selectedBatch->expiration_year : '' }}</p>
                    </div>

                    {{-- Product pictograms --}}
                    <div class="product-pictograms">
                        @foreach ($product->pictograms as $pictogram)
                            <img src="{{ Storage::url($pictogram->image) }}" alt="Pictograma">
                        @endforeach
                    </div>

                    {{-- Product weight --}}
                    <div class="product-weight">
                        {{ $selectedVariation?->formattedWeight() }} {{ $selectedVariation?->unitMeasurement?->unit_symbol }}
                    </div>

                    {{-- Product barcode --}}
                    <div class="product-barcode">
                        @if ($selectedVariation && $selectedVariation->gtin)
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($selectedVariation->gtin, 'EAN13', 2, 93, [0, 0, 0], true) }}" alt="barcode" />
                        @endif
                    </div>
                </div>

                @if ($global_label_count % $labels_per_page == 0 || $global_label_count == collect($printQueue)->sum('quantity'))
                    </div> {{-- Close the page --}}
                @endif
            @endfor
        @endforeach
        {{-- CSS Styles --}}
        <style>
        :root {
            /* Page settings */
            --page-size: {{ $firstVariation ? $firstVariation->labelGroup->page_size . ' ' . $firstVariation->labelGroup->page_orientation : 'A4 portrait' }};

            /* Margins */
            --page-margin-top: {{ $firstVariation ? $firstVariation->labelGroup->page_margin_top : 0 }}cm;
            --page-margin-right: {{ $firstVariation ? $firstVariation->labelGroup->page_margin_right : 0 }}cm;
            --page-margin-bottom: {{ $firstVariation ? $firstVariation->labelGroup->page_margin_bottom : 0 }}cm;
            --page-margin-left: {{ $firstVariation ? $firstVariation->labelGroup->page_margin_left : 0 }}cm;

            /* Label settings */
            --printing-area-width: {{ $firstVariation ? $firstVariation->labelGroup->printing_area_width : 0 }}cm;
            --printing-area-height: {{ $firstVariation ? $firstVariation->labelGroup->printing_area_height : 0 }}cm;

            --label-width: {{ $firstVariation ? $firstVariation->labelGroup->label_width : 0 }}cm;
            --label-height: {{ $firstVariation ? $firstVariation->labelGroup->label_height : 0 }}cm;
            --labels-per-row: {{ $firstVariation ? $firstVariation->labelGroup->labels_per_row : 1 }};
            --labels-row-gap: {{ $firstVariation ? $firstVariation->labelGroup->labels_row_gap : 0 }}cm;
            --labels-column-gap: {{ $firstVariation ? $firstVariation->labelGroup->labels_column_gap : 0 }}cm;

            /* Product name */
            --product-name-top: {{ $firstVariation ? $firstVariation->labelGroup->product_name_top : 0 }}cm;
            --product-name-left: {{ $firstVariation ? $firstVariation->labelGroup->product_name_left : 0 }}cm;
            --product-name-width: {{ $firstVariation ? $firstVariation->labelGroup->product_name_width : 0 }}cm;
            --product-name-height: {{ $firstVariation ? $firstVariation->labelGroup->product_name_height : 0 }}cm;
            --product-name-text-align: {{ $firstVariation ? $firstVariation->labelGroup->product_name_text_align : 'left' }};
            --product-name-font-size: {{ $firstVariation ? $firstVariation->labelGroup->product_name_font_size : '12px' }};

            /* Product properties */
            --product-properties-visibility: {{ $firstVariation ? $firstVariation->labelGroup->product_properties_visibility : 'hidden' }};
            --product-properties-left: {{ $firstVariation ? $firstVariation->labelGroup->product_properties_left : 0 }}cm;
            --product-properties-width: {{ $firstVariation ? $firstVariation->labelGroup->product_properties_width : 0 }}cm;

            --product-property-cure-top: {{ $firstVariation ? $firstVariation->labelGroup->product_property_cure_top : 0 }}cm;
            --product-property-viscosity-top: {{ $firstVariation ? $firstVariation->labelGroup->product_property_viscosity_top : 0 }}cm;
            --product-property-thickness-top: {{ $firstVariation ? $firstVariation->labelGroup->product_property_thickness_top : 0 }}cm;
            --product-property-width: {{ $firstVariation ? $firstVariation->labelGroup->product_property_width : 0 }}cm;
            --product-property-height: {{ $firstVariation ? $firstVariation->labelGroup->product_property_height : 0 }}cm;

            /* Product info */
            --product-info-top: {{ $firstVariation ? $firstVariation->labelGroup->product_info_top : 0 }}cm;
            --product-info-left: {{ $firstVariation ? $firstVariation->labelGroup->product_info_left : 0 }}cm;
            --product-info-width: {{ $firstVariation ? $firstVariation->labelGroup->product_info_width : 0 }}cm;
            --product-info-font-size: {{ $firstVariation ? $firstVariation->labelGroup->product_info_font_size : '12px' }};
            --product-info-line-height: {{ $firstVariation ? $firstVariation->labelGroup->product_info_line_height : '1.5' }};
            --product-info-padding: {{ $firstVariation ? $firstVariation->labelGroup->product_info_padding : 0 }}cm;

            /* Product batch */
            --product-batch-top: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_top : 0 }}cm;
            --product-batch-left: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_left : 0 }}cm;
            --product-batch-width: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_width : 0 }}cm;
            --product-batch-height: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_height : 0 }}cm;
            --product-batch-font-size: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_font_size : '12px' }};
            --product-batch-text-align: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_text_align : 'left' }};
            --product-batch-padding: {{ $firstVariation ? $firstVariation->labelGroup->product_batch_padding : 0 }}cm;

            /* Product pictograms */
            --product-pictograms-top: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_top : 0 }}cm;
            --product-pictograms-left: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_left : 0 }}cm;
            --product-pictograms-width: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_width : 0 }}cm;
            --product-pictograms-height: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_height : 0 }}cm;
            --product-pictograms-padding: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_padding : 0 }}cm;
            --product-pictograms-image-width: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_image_width : 0 }}cm;
            --product-pictograms-visibility: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_visibility : 'hidden' }};
            --product-pictograms-gap: {{ $firstVariation ? $firstVariation->labelGroup->product_pictograms_gap : 0 }}cm;

            /* Product weight */
            --product-weight-top: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_top : 0 }}cm;
            --product-weight-left: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_left : 0 }}cm;
            --product-weight-width: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_width : 0 }}cm;
            --product-weight-height: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_height : 0 }}cm;
            --product-weight-font-size: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_font_size : '12px' }};
            --product-weight-text-align: {{ $firstVariation ? $firstVariation->labelGroup->product_weight_text_align : 'left' }};

            /* Product barcode */
            --product-barcode-top: {{ $firstVariation ? $firstVariation->labelGroup->product_barcode_top : 0 }}cm;
            --product-barcode-left: {{ $firstVariation ? $firstVariation->labelGroup->product_barcode_left : 0 }}cm;
            --product-barcode-width: {{ $firstVariation ? $firstVariation->labelGroup->product_barcode_width : 0 }}cm;
            --product-barcode-height: {{ $firstVariation ? $firstVariation->labelGroup->product_barcode_height : 0 }}cm;
            --product-barcode-padding: {{ $firstVariation ? $firstVariation->labelGroup->product_barcode_padding : 0 }}cm;

            /* Product proportion */
            --product-proportion-top: {{ $firstVariation ? $firstVariation->labelGroup->proportion_top : 0 }}cm;
            --product-proportion-left: {{ $firstVariation ? $firstVariation->labelGroup->proportion_left : 0 }}cm;
            --product-proportion-width: {{ $firstVariation ? $firstVariation->labelGroup->proportion_width : 0 }}cm;
            --product-proportion-height: {{ $firstVariation ? $firstVariation->labelGroup->proportion_height : 0 }}cm;
            --product-proportion-font-size: {{ $firstVariation ? $firstVariation->labelGroup->proportion_font_size : '12px' }};
            --product-proportion-text-align: {{ $firstVariation ? $firstVariation->labelGroup->proportion_text_align : 'left' }};        
            --product-proportion-visibility: {{ $firstVariation ? $firstVariation->labelGroup->proportion_visibility : 'hidden' }};

            /* Product Description */
            --product-description-top: {{ $firstVariation ? $firstVariation->labelGroup->product_description_top : 0 }}cm;
            --product-description-left: {{ $firstVariation ? $firstVariation->labelGroup->product_description_left : 0 }}cm;
            --product-description-width: {{ $firstVariation ? $firstVariation->labelGroup->product_description_width : 0 }}cm;
            --product-description-height: {{ $firstVariation ? $firstVariation->labelGroup->product_description_height : 0 }}cm;
            --product-description-font-size: {{ $firstVariation ? $firstVariation->labelGroup->product_description_font_size : '12px' }};
            --product-description-text-align: {{ $firstVariation ? $firstVariation->labelGroup->product_description_text_align : 'left' }};        
            --product-description-visibility: {{ $firstVariation ? $firstVariation->labelGroup->product_description_visibility : 'hidden' }};        
        }

        @media screen {
            .print-content {
                display: none;
            }
        } 
     
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-family: Arial, Helvetica, sans-serif !important;
                box-sizing: border-box;
                background-color: transparent !important;
                color: #000 !important;
            }

            aside,
            .fi-topbar,
            .fi-header, 
            .fi-main-sidebar,
            .fi-sidebar-header,
            .fi-sidebar-nav,
            .no-print {
                display: none !important;
            }

            .fi-main {
                padding: 0;
                margin: 0;
                overflow: visible !important;
                z-index: 999 !important;
            }

            * {
                margin: 0;
            }
            
            header,
            main,
            section {
                padding: 0 !important;
                margin: 0 !important;
            }

            @page {
                size: var(--page-size);
                margin: 0;
            }

            .print-label-page {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: start;
                box-sizing: border-box;
                padding: 0;
                margin: 0 var(--page-margin-right) var(--page-margin-bottom) var(--page-margin-left);
                padding-top: var(--page-margin-top);
                width: var(--printing-area-width);
                height: auto;
                row-gap: var(--labels-row-gap);
                column-gap: var(--labels-column-gap);
            }
            
            .print-label-container {
                flex: 0 0 var(--label-width);
                height: var(--label-height);
                position: relative;
            }

            .print-label-container p {
                margin: 0;
                padding: 0;
                line-height: 1.2;
            }

            .page-break {
                page-break-after: always;
            }

            .print-label-container p {
                margin: 0;
                padding: 0;
                line-height: 1.2;
            }

            .page-break {
                page-break-after: always;
            }

            /* Product elements */
            .product-name {
                position: absolute;
                top: var(--product-name-top);
                left: var(--product-name-left);
                width: var(--product-name-width);
                height: var(--product-name-height);
                overflow: hidden;
                font-size: var(--product-name-font-size);
                font-weight: bold;
                text-align: var(--product-name-text-align);
            }

            /* Product properties  */
            .product-properties {
                position: absolute;
                left: var(--product-properties-left);
                width: var(--product-properties-width);
                visibility: var(--product-properties-visibility);
            }

            .product-properties .product-property {
                position: absolute;
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                height: var(--product-property-height);
                width: var(--product-properties-width);
                font-size: 10px;
                align-content: end;
                text-align: center;
            }

            .product-property div {
                flex: 0 0 var(--product-property-width);
            }

            .product-property .active::before {
                content: "●"; 
                font-size: 12px; 
                color: black;
                display: inline-block;
                line-height: 1; 
            }

            .product-property.cure {
                top: var(--product-property-cure-top);
            }

            .product-property.viscosity {
                top: var(--product-property-viscosity-top);
            }

            .product-property.thickness {
                top: var(--product-property-thickness-top);
            }

            /* Product info */
            .product-info {
                position: absolute;
                top: var(--product-info-top);
                left: var(--product-info-left);
                width: var(--product-info-width) !important;
                padding: var(--product-info-padding);
                overflow: hidden;
                font-size: var(--product-info-font-size);
            }
            
            /* Product proportion  */
            .product-proportion {
                position: absolute;
                top: var(--product-proportion-top);
                left: var(--product-proportion-left);
                width: var(--product-proportion-width);
                height: var(--product-proportion-height);
                overflow: hidden;
                font-size: var(--product-proportion-font-size);
                font-weight: bold;
                text-align: var(--product-proportion-text-align);
                visibility: var(--product-proportion-visibility);
                text-transform: uppercase;
            }

            /* Product description  */
            .product-description {
                position: absolute;
                top: var(--product-description-top);
                left: var(--product-description-left);
                width: var(--product-description-width);
                height: var(--product-description-height);
                overflow: hidden;
                font-size: var(--product-description-font-size);
                font-weight: bold;
                text-align: var(--product-description-text-align);
                visibility: var(--product-description-visibility);
                text-transform: uppercase;
            }

            /* Product batch */
            .product-batch {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: start;
                position: absolute;
                top: var(--product-batch-top);
                left: var(--product-batch-left);
                width: var(--product-batch-width);
                height: var(--product-batch-height);
                padding: var(--product-batch-padding);
                overflow: hidden;
                text-align: var(--product-batch-text-align);
                font-size: var(--product-batch-font-size);
            }

            /* Product pictograms  */
            .product-pictograms {
                position: absolute;
                display: grid;
                grid-template-columns: repeat(3, var(--product-pictograms-image-width));
                column-gap: var(--product-pictograms-gap);
                row-gap: var(--product-pictograms-gap);
                top: var(--product-pictograms-top);
                left: var(--product-pictograms-left);
                width: var(--product-pictograms-width);
                height: var(--product-pictograms-height);
                padding: var(--product-pictograms-padding);
                overflow: hidden;
                visibility: var(--product-pictograms-visibility);
            }

            .product-pictograms img {
                width: 100%;
                height: auto;
            }

            /* Product weight */
            .product-weight {
                position: absolute;
                display: flex;
                justify-content: center;
                align-items: center;
                top: var(--product-weight-top);
                left: var(--product-weight-left);
                width: var(--product-weight-width);
                height: var(--product-weight-height);
                overflow: hidden;
                font-size: var(--product-weight-font-size);
                text-align: var(--product-weight-text-align);
                font-weight: bold;
            }

            /* Barcode  */
            .product-barcode {
                position: absolute;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                overflow: hidden;
                padding: var(--product-barcode-padding);
                top: var(--product-barcode-top);
                left: var(--product-barcode-left);
                width: var(--product-barcode-width);
                height: var(--product-barcode-height);
            }
           
            .product-barcode img {
               width: 100%;
               height: auto;
            }
        }
        </style>

   
<script>
function printDiv(divId) {
    const content = document.querySelector('.' + divId).innerHTML;
    const printWindow = window.open('', '', 'height=800,width=1200');
    printWindow.document.write('<html><head><title>Impressão</title>');
    // Copiar estilos da página principal
    document.querySelectorAll('link[rel="stylesheet"], style').forEach(node => {
        printWindow.document.write(node.outerHTML);
    });
    printWindow.document.write('</head><body>');
    printWindow.document.write(content);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>
    </div>
@endif

    </div></div>

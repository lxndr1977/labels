<div>

    <!-- Print settings -->
    <div class="no-print bg-white rounded-lg shadow-sm">
         <div class="border-b border-gray-200 fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white px-6 py-4">Configuração da impressão</div>
        <div class="grid grid-cols-4 gap-x-4 justify-between items-end  p-6">
            <div class="grid gap-y-2 ">
                <label for="batch" class="inline-flex items-center gap-x-3 text-sm">Lote</label>
                <div class="fi-input-wrp w-full flex rounded-lg shadow-xs ring-1 transition duration-75 bg-white dark:bg-white/5 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-2 ring-gray-950/10 dark:ring-white/20 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600 dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500 fi-fo-select">
                    <select wire:model="lote" wire:change="getBatch" name="batch" class="fi-select-input block w-full border-none bg-transparent py-1.5 pe-8 text-base text-gray-950 transition duration-75 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:var(--color-gray-500)] dark:text-white dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:var(--color-gray-400)] sm:text-sm sm:leading-6 [&_optgroup]:bg-white dark:[&_optgroup]:bg-gray-900 [&_option]:bg-white dark:[&_option]:bg-gray-900 ps-3">
                        <option value="">Selecione um lote</option>
                        @foreach ($product->batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->identification }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Campo de número de rótulos -->
            <div class="grid gap-y-2">
                <label for="total_labels" class="inline-flex items-center gap-x-3 text-sm">Quantidade</label>
                <input 
                    class="fi-input block w-auto bg-white dark:bg-white/5 border-gray-200 rounded-lg shadow-xs py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 focus:border-primary-600 disabled:text-gray-500 disabled:[-webkit-text-fill-color:var(--color-gray-500)] disabled:placeholder:[-webkit-text-fill-color:var(--color-gray-400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:var(--color-gray-400)] dark:disabled:placeholder:[-webkit-text-fill-color:var(--color-gray-500)] sm:text-sm sm:leading-6 ps-3 pe-3" 
                    type="number" 
                    name="total_labels" 
                    wire:model="total_labels" 
                    min="1" 
                    x-data 
                    x-on:blur="$wire.handleTotalLabelsBlur()" />
            </div>

            <!-- Seleção de posição de início -->
            <div class="grid gap-y-2">
                <label for="start_at_position" class="inline-flex items-center gap-x-3 text-sm">Imprimir na posição</label>
                <div class="fi-input-wrp flex rounded-lg shadow-xs ring-1 transition duration-75 bg-white dark:bg-white/5 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-2 ring-gray-950/10 dark:ring-white/20 [&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-600 dark:[&:not(:has(.fi-ac-action:focus))]:focus-within:ring-primary-500 fi-fo-select">
                    <select id="start_at_position" name="start_at_position" wire:model="start_at_position" class="fi-select-input block w-full border-none bg-transparent py-1.5 pe-8 text-base text-gray-950 transition duration-75 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:var(--color-gray-500)] dark:text-white dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:var(--color-gray-400)] sm:text-sm sm:leading-6 [&_optgroup]:bg-white dark:[&_optgroup]:bg-gray-900 [&_option]:bg-white dark:[&_option]:bg-gray-900 ps-3">
                    <option value="1">Posição 1</option>
                    <option value="2">Posição 2</option>
                    <option value="3">Posição 3</option>
                    <option value="4">Posição 4</option>
                    <option value="5">Posição 5</option>
                    <option value="6">Posição 6</option>
                    <option value="7">Posição 7</option>
                    <option value="8">Posição 8</option>
                    <option value="9">Posição 9</option>
                    <option value="10">Posição 10</option>
                    <option value="11">Posição 11</option>
                    <option value="12">Posição 12</option>
                    </select>
                </div>
            </div>

            <!-- Botão de Impressão -->
            <div>
                <button 
                    type="button" 
                    class="print-button fi-btn bg-gray-400 relative grid-flow-col items-center justify-center font-semibold outline-hidden transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-xs bg-custom-600 text-white hover:bg-primary-500 focus-visible:ring-primary-500/50 dark:bg-primary-500 dark:hover:bg-primary-400 dark:focus-visible:ring-primary-400/50 fi-ac-action fi-ac-btn-action" 
                    x-data="{ lote: @this.lote }"
                    x-on:click="window.print()"
                    :disabled="!@this.lote || @this.lote === ''"
                    :class="{ 'bg-primary-600': @this.lote || @this.lote !== '' }">
                    Imprimir
                </button>
            </div>
        </div>
    </div>

    <!-- Label and package information -->

    <div class="no-print m-0 p-0">
        <div class="m-0 p-0">
            @php $current_label = 0  @endphp
        </div>

        <div class="no-print  bg-white rounded-lg shadow-sm border-gray-400 col-span-3">
            <div class="border-b border-gray-200 text-base font-semibold text-gray-950 dark:text-white px-6 py-4 flex items-center">
                <div class="inline-flex gap-x-2 items-center">
                    Confira o rótulo antes de imprimir
                </div>
            </div>
            <div class="grid grid-cols-3 gap-x-8 items-start p-6">
                @if ($product->labelGroup && $product->labelGroup->image)
                    <div class="col-span-2">
                        <p class="mb-2 font-bold">{{ $product->labelGroup->name }}</p>
                        <img src="{{ Storage::url($product->labelGroup->image) }}" alt="Imagem do Grupo de Rótulos" class="max-h-96">
                    </div>
                    <div>
                        <p class="mb-2 font-bold">{{ $product->package->description }}</p>
                        <img src="{{ Storage::url($product->package->image) }}" alt="Imagem da Embalagem" class="package-image">
                    </div>
                @endif
            </div>
        </div>
    </div>
    

    <!-- Print content  -->
    @php
        $labels_per_page = $product->labelGroup->labels_per_page;
        $start_position = 1;  // Posição inicial da impressão
    @endphp

    @for ($current_label = 1; $current_label <= $start_position + $total_labels - 1; $current_label++)
        @if (($current_label - 1) % $labels_per_page == 0)
            <div class="print-label-page page-break">
        @endif

        <div class="print-label-container">
            <!-- Product name  -->
             <div class="product-name">
                {{ $product->comercial_name}}
            </div>

            <div class="product-info">
                <p>ONU: {{ $product->un_number }}</p>
                <p>Classe Risco: {{ $product->hazardClass->class_number }}</p>
            </div>

            <!-- Product properties -->

            <div class="product-properties">aaaaaaaaaaaaaa
                <div class="product-property cure">
                    <div>
                        <span class={{ $product->cure == 'lenta' ? 'active' : '' }}></span>
                    </div>
                    <div>
                        <span class={{ $product->cure == 'rapida' ? 'active' : '' }}></span>
                    </div>
                    <div></div>
                </div>
                <div class="product-property viscosity">
                    <div>
                        <span class={{ $product->viscosity == 'baixa' ? 'active' : '' }}></span>
                    </div>
                    <div>
                        <span class={{ $product->viscosity == 'média' ? 'active' : '' }}></span>
                    </div>
                    <div>
                        <span class={{ $product->viscosity == 'alta' ? 'active' : '' }}></span>
                    </div>
                </div>
                <div class="product-property thickness">
                    <div>
                        <span class={{ $product->thickness == 'baixa' ? 'active' : '' }}></span>
                    </div>
                    <div>
                        <span class={{ $product->thickness == 'média' ? 'active' : '' }}></span>
                    </div>
                    <div>
                        <span class={{ $product->thickness == 'alta' ? 'active' : '' }}></span>
                    </div>
                </div>
            </div>

            <!-- Product batch -->

            <div class="product-batch">
                <p>Lote: {{ $selectedBatch ? $selectedBatch->identification : ''}}</p>    
                <p>Validade: {{ $selectedBatch ? 
                                $selectedBatch->expiration_month . '/' . $selectedBatch->expiration_year 
                                : ''}}
                </p>
            </div>

            <!-- Product pictograms -->

            <div class="product-pictograms">
                @foreach ($product->pictograms as $pictogram)
                    <img src="{{ Storage::url( $pictogram->image) }}" alt="Pictograma">
                @endforeach
            </div>

            <!-- Product weight -->
            <div class="product-weight">
                {{ $product->weight }} {{ $product->unitMeasurement->unit_symbol }}
            </div>

            <!-- Produc barcode  -->

            <div class="product-barcode">
                 {!! DNS1D::getBarcodeSVG('4445645656', 'EAN13', 1, 62)!!}
            </div>

            @if ($current_label < $start_position)
                <span class="note">Não imprimir</span>
            @elseif ($current_label == $start_position)
                <div></div>
            @endif
        </div>

        @if (($current_label % $labels_per_page == 0 || $current_label == $start_position + $total_labels - 1) && $current_label >= $start_position)
            </div>
        @endif
    @endfor

    <style>
        :root {
            /* Page settings */

            --page-size: {{ $product->labelGroup->page_size . ' ' . $product->labelGroup->page_orientation }};

            /* Margins */

            --page-margin-top: {{ $product->labelGroup->page_margin_top }}cm;
            --page-margin-right: {{ $product->labelGroup->page_margin_right }}cm;
            --page-margin-bottom: {{ $product->labelGroup->page_margin_bottom }}cm;
            --page-margin-left: {{ $product->labelGroup->page_margin_left }}cm;

            /* Label settings */

            --printing-area-width: {{ $product->labelGroup->printing_area_width }}cm;
            --printing-area-height: {{ $product->labelGroup->printing_area_height }}cm;

            --label-width: {{ $product->labelGroup->label_width }}cm;
            --label-height: {{ $product->labelGroup->label_height }}cm;
            --labels-per-row: {{ $product->labelGroup->labels_per_row }};
            --labels-row-gap: {{ $product->labelGroup->labels_row_gap }}cm;
            --labels-column-gap: {{ $product->labelGroup->labels_column_gap }}cm;

            /* Product name */

            --product-name-top: {{ $product->labelGroup->product_name_top }}cm;
            --product-name-left: {{ $product->labelGroup->product_name_left }}cm;
            --product-name-width: {{ $product->labelGroup->product_name_width }}cm;
            --product-name-height: {{ $product->labelGroup->product_name_height }}cm;
            --product-name-text-align: {{ $product->labelGroup->product_name_text_align }};
            --product-name-font-size: {{ $product->labelGroup->product_name_font_size }};

              /* Product properties */

            --product-properties-visibility: {{ $product->labelGroup->product_properties_visibility }};
            --product-properties-left: {{ $product->labelGroup->product_properties_left }}cm;
            --product-properties-width: {{ $product->labelGroup->product_properties_width }}cm;

            --product-property-cure-top: {{ $product->labelGroup->product_property_cure_top }}cm;
            --product-property-viscosity-top: {{ $product->labelGroup->product_property_viscosity_top }}cm;
            --product-property-thickness-top: {{ $product->labelGroup->product_property_thickness_top }}cm;
            --product-property-width: {{ $product->labelGroup->product_property_width }}cm;
            --product-property-height: {{ $product->labelGroup->product_property_height }}cm;

            /* Product info */

            --product-info-top: {{ $product->labelGroup->product_info_top }}cm;
            --product-info-left: {{ $product->labelGroup->product_info_left }}cm;
            --product-info-width: {{ $product->labelGroup->product_info_width }}cm;
            --product-info-font-size: {{ $product->labelGroup->product_info_font_size }};
            --product-info-line-height: {{ $product->labelGroup->product_info_line_height }};
            --product-info-padding: {{ $product->labelGroup->product_info_padding }}cm;

            /* Product batch */

            --product-batch-top: {{ $product->labelGroup->product_batch_top }}cm;
            --product-batch-left: {{ $product->labelGroup->product_batch_left }}cm;
            --product-batch-width: {{ $product->labelGroup->product_batch_width }}cm;
            --product-batch-height: {{ $product->labelGroup->product_batch_height }}cm;
            --product-batch-font-size: {{ $product->labelGroup->product_batch_font_size }};
            --product-batch-text-align: {{ $product->labelGroup->product_batch_text_align }};
            --product-batch-padding: {{ $product->labelGroup->product_batch_padding }}cm;

            /* Product pictograms */

            --product-pictograms-top: {{ $product->labelGroup->product_pictograms_top }}cm;
            --product-pictograms-left: {{ $product->labelGroup->product_pictograms_left }}cm;
            --product-pictograms-width: {{ $product->labelGroup->product_pictograms_width }}cm;
            --product-pictograms-height: {{ $product->labelGroup->product_pictograms_height }}cm;
            --product-pictograms-padding: {{ $product->labelGroup->product_pictograms_padding }}cm;
            --product-pictograms-image-width: {{ $product->labelGroup->product_pictograms_image_width }}cm;
            --product-pictograms-visibility: {{ $product->labelGroup->product_pictograms_visibility }};
            --product-pictograms-gap: {{ $product->labelGroup->product_pictograms_gap }}cm;


            /* Product weight */

            --product-weight-top: {{ $product->labelGroup->product_weight_top }}cm;
            --product-weight-left: {{ $product->labelGroup->product_weight_left }}cm;
            --product-weight-width: {{ $product->labelGroup->product_weight_width }}cm;
            --product-weight-height: {{ $product->labelGroup->product_weight_height }}cm;
            --product-weight-font-size: {{ $product->labelGroup->product_weight_font_size }};
            --product-weight-text-align: {{ $product->labelGroup->product_weight_text_align }};

            /* Product barcode */

            --product-barcode-top: {{ $product->labelGroup->product_barcode_top }}cm;
            --product-barcode-left: {{ $product->labelGroup->product_barcode_left }}cm;
            --product-barcode-width: {{ $product->labelGroup->product_barcode_width }}cm;
            --product-barcode-height: {{ $product->labelGroup->product_barcode_height }}cm;
            --product-barcode-padding: {{ $product->labelGroup->product_barcode_padding }}cm;
        }


     
        @media print {
            body {
                margin: 0 !important;
                padding: 0 !important;
                font-family: Arial, Helvetica, sans-serif !important;
                box-sizing: border-box;
                background-color: transparent; /* Ajuste para evitar fundo branco */
                color: #000 !important;
            }

            @page {
                size: var(--page-size);
                margin: 0; /* Remover padding, pois não é aplicável */
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
                border: 1px dashed #000;
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

            /* Product name */

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
                display: grid;
                grid-template-columns: repeat(3, var(--product-property-width));
                height: var(--product-property-height);
                width: var(--product-properties-width);
                font-size: 10px;
                align-content: end;
                text-align: center;
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
                /* border: 1px solid red; */
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
            

        }

    </style>
</div>


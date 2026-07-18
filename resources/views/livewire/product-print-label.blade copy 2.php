<div>
   <!-- Print settings -->

   <div class="no-print bg-white rounded-lg shadow-sm mb-5">
      <div
         class="border-b border-gray-200 fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white px-6 py-4">
         Configuração da impressão</div>

      <div class="p-6">
         <span class="d-block text-sm">Produto</span>
         <h2 class="text-2xl font-bold text-gray-950 dark:text-white mb-4">
            {{ $product->comercial_name }}
         </h2>

         {{ $this->productSchema }}



      </div>

   </div>

   <!-- Label and package information -->

   <div class="no-print m-0 p-0 mb-6">
      <div class="m-0 p-0">
         @php $current_label = 0  @endphp
      </div>

      <div class="no-print  bg-white rounded-lg shadow-sm border-gray-400 col-span-3">
         <div
            class="border-b border-gray-200 text-base font-semibold text-gray-950 dark:text-white px-6 py-4 flex items-center">
            <div class="inline-flex gap-x-2 items-center">
               Confira o rótulo antes de imprimir
            </div>
         </div>

         <div class="p-6">

            <div class="grid grid-cols-3 gap-x-8 items-start p-6">
               @if ($selectedVariation && $selectedVariation->labelGroup && $selectedVariation->labelGroup->image && $selectedBatch)
                  <div class="col-span-2">
                     <p class="mb-2 font-bold">{{ $selectedVariation->labelGroup->name }}</p>
                     <img src="{{ Storage::url($selectedVariation->labelGroup->image) }}"
                        alt="Imagem do Grupo de Rótulos" class="max-h-96">
                  </div>
                  <div>
                     <p class="mb-2 font-bold">{{ $selectedVariation->package->description }}</p>
                     <img src="{{ Storage::url($selectedVariation->package->image) }}" alt="Imagem da Embalagem"
                        class="package-image">
                  </div>
               @else
                  <div class="col-span-3">
                     Selecione uma variação de peso e um lote
                  </div>
               @endif
            </div>
         </div>
      </div>
   </div>

   <div class="no-print">
      <!-- Print button -->
      <button
         type="button"
         class="print-button fi-btn bg-gray-400 relative grid-flow-col items-center justify-center font-semibold outline-hidden transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-xs bg-custom-600 text-white hover:bg-primary-500 focus-visible:ring-primary-500/50 dark:bg-primary-500 dark:hover:bg-primary-400 dark:focus-visible:ring-primary-400/50 fi-ac-action fi-ac-btn-action"
         x-data="{
             batch: @entangle('batch'),
             product_variation: @entangle('product_variation')
         }"
         x-show="batch && batch !== '' && product_variation && product_variation !== ''"
         x-on:click="
                // Atualiza os dados do Livewire antes de imprimir
                $wire.call('handleTotalLabelsBlur').then(() => {
                    window.print();
                });
            "
         :class="{ 'bg-primary-600': batch && batch !== '' && product_variation && product_variation !== '' }">
         Imprimir rótulo
      </button>

   </div>
   <div id="printableArea2">

   @if ($selectedVariation)
      <!-- Print content  -->
      @php
         // Define the number of labels per page
         $labels_per_page = $selectedVariation ? $selectedVariation->labelGroup->labels_per_page : 1;
      @endphp

      <!-- Print content  -->
      @php
         // Define the number of labels per page
         $labels_per_page = $selectedVariation ? $selectedVariation->labelGroup->labels_per_page : 1;
      @endphp

      @for ($current_label = 1; $current_label <= $total_labels + $start_at_position - 1; $current_label++)
         @if (($current_label - 1) % $labels_per_page == 0)
            <div
               class="print-label-page {{ $current_label + $labels_per_page - 1 < $total_labels + $start_at_position - 1 ? 'page-break' : '' }}">
         @endif

         <div class="print-label-container">
            @if ($current_label < $start_at_position)
               <!-- Empty label for positions before the starting point -->
               <div class="empty-label">
                  <!-- Content for empty labels -->
                  <p></p>
               </div>
            @else
               <!-- Print the actual label content -->
               <div class="product-name">
                  {{ $product->label_name }}
               </div>

               <div class="product-info">
                  <p>ONU: {{ $product->un_number }}</p>
                  <p>Classe Risco: {{ $product->hazardClass->class_number }}</p>
               </div>

               <div class="product-proportion">
                  @if (!empty($product->proportion))
                     <p> {{ $product->proportion }}</p>
                  @endif
               </div>

               <div class="product-description">
                  <p>{{ $product->label_product_description }}</p>
               </div>

               <!-- Product properties -->
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

               <!-- Product batch -->
               <div class="product-batch">
                  <p>Lote: {{ $selectedBatch ? $selectedBatch->identification : '' }}</p>
                  <p>Validade:
                     {{ $selectedBatch ? $selectedBatch->expiration_month . '/' . $selectedBatch->expiration_year : '' }}
                  </p>
               </div>

               <!-- Product pictograms -->
               <div class="product-pictograms">
                  @foreach ($product->pictograms as $pictogram)
                     <img src="{{ Storage::url($pictogram->image) }}" alt="Pictograma">
                  @endforeach
               </div>

               <!-- Product weight -->
               <div class="product-weight">
                  {{ $selectedVariation?->formattedWeight() }}
                  {{ $selectedVariation?->unitMeasurement?->unit_symbol }}
               </div>

               <!-- Product barcode -->
               <div class="product-barcode">
                  @if ($selectedVariation && filter_var($selectedVariation->gtin, FILTER_VALIDATE_INT) !== false)
                     <img
                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG($selectedVariation->gtin, 'EAN13', 2, 93, [0, 0, 0], true) }}"
                        alt="barcode" />
                  @endif
               </div>
            @endif
         </div>

         @if ($current_label % $labels_per_page == 0 || $current_label == $total_labels + $start_at_position - 1)
</div> <!-- Close the page if the label limit is reached -->
@endif
@endfor


<style>
   :root {
      /* Page settings */
      --page-size: {{ $selectedVariation ? $selectedVariation->labelGroup->page_size . ' ' . $selectedVariation->labelGroup->page_orientation : 'A4 portrait' }};

      /* Margins */
      --page-margin-top: {{ $selectedVariation ? $selectedVariation->labelGroup->page_margin_top : 0 }}cm;
      --page-margin-right: {{ $selectedVariation ? $selectedVariation->labelGroup->page_margin_right : 0 }}cm;
      --page-margin-bottom: {{ $selectedVariation ? $selectedVariation->labelGroup->page_margin_bottom : 0 }}cm;
      --page-margin-left: {{ $selectedVariation ? $selectedVariation->labelGroup->page_margin_left : 0 }}cm;

      /* Label settings */
      --printing-area-width: {{ $selectedVariation ? $selectedVariation->labelGroup->printing_area_width : 0 }}cm;
      --printing-area-height: {{ $selectedVariation ? $selectedVariation->labelGroup->printing_area_height : 0 }}cm;

      --label-width: {{ $selectedVariation ? $selectedVariation->labelGroup->label_width : 0 }}cm;
      --label-height: {{ $selectedVariation ? $selectedVariation->labelGroup->label_height : 0 }}cm;
      --labels-per-row: {{ $selectedVariation ? $selectedVariation->labelGroup->labels_per_row : 1 }};
      --labels-row-gap: {{ $selectedVariation ? $selectedVariation->labelGroup->labels_row_gap : 0 }}cm;
      --labels-column-gap: {{ $selectedVariation ? $selectedVariation->labelGroup->labels_column_gap : 0 }}cm;

      /* Product name */
      --product-name-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_top : 0 }}cm;
      --product-name-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_left : 0 }}cm;
      --product-name-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_width : 0 }}cm;
      --product-name-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_height : 0 }}cm;
      --product-name-text-align: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_text_align : 'left' }};
      --product-name-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->product_name_font_size : '12px' }};

      /* Product properties */
      --product-properties-visibility: {{ $selectedVariation ? $selectedVariation->labelGroup->product_properties_visibility : 'hidden' }};
      --product-properties-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_properties_left : 0 }}cm;
      --product-properties-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_properties_width : 0 }}cm;

      --product-property-cure-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_property_cure_top : 0 }}cm;
      --product-property-viscosity-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_property_viscosity_top : 0 }}cm;
      --product-property-thickness-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_property_thickness_top : 0 }}cm;
      --product-property-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_property_width : 0 }}cm;
      --product-property-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_property_height : 0 }}cm;

      /* Product info */
      --product-info-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_top : 0 }}cm;
      --product-info-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_left : 0 }}cm;
      --product-info-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_width : 0 }}cm;
      --product-info-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_font_size : '12px' }};
      --product-info-line-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_line_height : '1.5' }};
      --product-info-padding: {{ $selectedVariation ? $selectedVariation->labelGroup->product_info_padding : 0 }}cm;

      /* Product batch */
      --product-batch-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_top : 0 }}cm;
      --product-batch-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_left : 0 }}cm;
      --product-batch-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_width : 0 }}cm;
      --product-batch-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_height : 0 }}cm;
      --product-batch-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_font_size : '12px' }};
      --product-batch-text-align: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_text_align : 'left' }};
      --product-batch-padding: {{ $selectedVariation ? $selectedVariation->labelGroup->product_batch_padding : 0 }}cm;

      /* Product pictograms */
      --product-pictograms-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_top : 0 }}cm;
      --product-pictograms-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_left : 0 }}cm;
      --product-pictograms-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_width : 0 }}cm;
      --product-pictograms-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_height : 0 }}cm;
      --product-pictograms-padding: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_padding : 0 }}cm;
      --product-pictograms-image-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_image_width : 0 }}cm;
      --product-pictograms-visibility: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_visibility : 'hidden' }};
      --product-pictograms-gap: {{ $selectedVariation ? $selectedVariation->labelGroup->product_pictograms_gap : 0 }}cm;

      /* Product weight */
      --product-weight-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_top : 0 }}cm;
      --product-weight-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_left : 0 }}cm;
      --product-weight-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_width : 0 }}cm;
      --product-weight-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_height : 0 }}cm;
      --product-weight-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_font_size : '12px' }};
      --product-weight-text-align: {{ $selectedVariation ? $selectedVariation->labelGroup->product_weight_text_align : 'left' }};

      /* Product barcode */
      --product-barcode-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_barcode_top : 0 }}cm;
      --product-barcode-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_barcode_left : 0 }}cm;
      --product-barcode-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_barcode_width : 0 }}cm;
      --product-barcode-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_barcode_height : 0 }}cm;
      --product-barcode-padding: {{ $selectedVariation ? $selectedVariation->labelGroup->product_barcode_padding : 0 }}cm;


      /* Product proportion */
      --product-proportion-top: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_top : 0 }}cm;
      --product-proportion-left: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_left : 0 }}cm;
      --product-proportion-width: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_width : 0 }}cm;
      --product-proportion-height: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_height : 0 }}cm;
      --product-proportion-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_font_size : '12px' }};
      --product-proportion-text-align: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_text_align : 'left' }};
      --product-proportion-visibility: {{ $selectedVariation ? $selectedVariation->labelGroup->proportion_visibility : 'hidden' }};


      /* Product Description */
      --product-description-top: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_top : 0 }}cm;
      --product-description-left: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_left : 0 }}cm;
      --product-description-width: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_width : 0 }}cm;
      --product-description-height: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_height : 0 }}cm;
      --product-description-font-size: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_font_size : '12px' }};
      --product-description-text-align: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_text_align : 'left' }};
      --product-description-visibility: {{ $selectedVariation ? $selectedVariation->labelGroup->product_description_visibility : 'hidden' }};

   }

   @media print {

      /* Força reset completo na impressão */
      html,
      body {
         height: 100% !important;
         margin: 0 !important;
         padding: 0 !important;
      }


      /* Mostra apenas as páginas de impressão */
      .print-label-page {
         display: flex !important;
         /* position: absolute !important; */
         top: 0 !important;
         left: 0 !important;
      }

      /* Ajuste mais específico para a primeira página */
      .print-label-page:first-of-type {
         margin-top: var(--page-margin-top) !important;
         padding-top: 0 !important;
      }
   }


   @media screen {
      .print-label-page {
         display: none;
      }

   }

   @media print {
      body {
         margin: 0 !important;
         padding: 0 !important;
         font-family: Arial, Helvetica, sans-serif !important;
         box-sizing: border-box;
         background-color: transparent;
         /* Ajuste para evitar fundo branco */
         color: #000 !important;
      }

      @page {
         size: var(--page-size);
         margin: 0;
         /* Remover padding, pois não é aplicável */
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
         /* border: 1px dashed #000;  */
         position: relative;
      }

      .print-label-container p {
         margin: 0;
         padding: 0;
         line-height: 1.2;
      }

      .page-break {
         page-break-after: always !important;
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
         display: flex;
         flex-direction: row;
         justify-content: space-between;
         /* grid-template-columns: repeat(3, var(--product-property-width)); */
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

      /* Product proportion  */
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
   document.addEventListener('keydown', function(event) {
      if (event.ctrlKey && event.key === 'p') {
         event.preventDefault(); // Impede a ação padrão do navegador
         alert('O atalho CTRL + P foi desativado.');
      }
   });
</script>
@endif

</div>
</div>

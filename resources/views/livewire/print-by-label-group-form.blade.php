{{-- Adicione a importação do helper Arr no topo da sua view --}}
@php use Illuminate\Support\Arr; @endphp

<div>
   <div class="relative grid grid-cols-1 md:grid-cols-2 gap-6 ">
      <div class="">

         <x-filament::section>
            <x-slot name="heading">1. Selecione o Grupo de Etiquetas</x-slot>
            <x-filament::input.wrapper>
               <x-filament::input.select wire:model.live="selectedLabelGroupId">
                  <option value="">Selecione um grupo...</option>
                  @foreach ($this->labelGroups as $group)
                     <option value="{{ $group->id }}">{{ $group->name }}</option>
                  @endforeach
               </x-filament::input.select>
            </x-filament::input.wrapper>
         </x-filament::section>

         @if ($selectedLabelGroupId)
            {{-- 2. Pesquisa e Lista de Produtos --}}
            <x-filament::section>
               <x-slot name="heading">2. Selecione os Produtos para Impressão</x-slot>
               <div class="mb-4">
                  <x-filament::input.wrapper>
                     <x-filament::input wire:model.live.debounce.300ms="searchProduct" type="text"
                        placeholder="Digite para filtrar produtos..." />
                  </x-filament::input.wrapper>
               </div>
               <div wire:loading.class="opacity-50" class="space-y-2">
                  @forelse($this->availableProductVariations as $variation)
                     <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                        <div>
                           <p class="font-semibold text-gray-800">
                              {{ $variation->product->label_name ?: $variation->product->comercial_name }}</p>
                           <p class="text-sm text-gray-600">
                              {{ $variation->formattedWeight() }} {{ $variation->unitMeasurement?->unit_symbol }}
                              @if ($variation->package)
                                 ({{ $variation->package->description }})
                              @endif
                           </p>
                        </div>
                        <x-filament::button wire:click="openBatchModal({{ $variation->id }})" icon="heroicon-o-plus">
                           Adicionar
                        </x-filament::button>
                     </div>
                  @empty
                     <div class="text-center py-8 text-gray-500">
                        Nenhum produto encontrado.
                     </div>
                  @endforelse
               </div>
               <div class="mt-4">
                  {{ $this->availableProductVariations->links() }}
               </div>
            </x-filament::section>
         @endif
      </div>

      <div class="sticky top-20 self-start">
         {{-- 3. Lista de Impressão --}}
      @if (!empty($printQueue))
         <x-filament::section>
            <x-slot name="heading">3. Lista de Impressão</x-slot>
            <x-slot name="headerEnd">
               <x-filament::button wire:click="clearQueue" color="gray" icon="heroicon-o-trash"
                  onclick="return confirm('Limpar toda a lista?')">
                  Limpar Lista
               </x-filament::button>
            </x-slot>
            <div class="overflow-x-auto">
               <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                     <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produto</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Lote</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Qtd</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                     </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                     @foreach ($printQueue as $key => $item)
                        <tr>
                           <td class="px-4 py-3">
                              <p class="font-medium">{{ $item['product_name'] }}</p>
                              <p class="text-sm text-gray-500">{{ $item['weight'] }}</p>
                           </td>
                           <td class="px-4 py-3">
                              <p class="font-medium">{{ $item['batch_identification'] }}</p>
                              <p class="text-sm text-gray-500">Val: {{ $item['expiration'] }}</p>
                           </td>
                           <td class="px-4 py-3 text-center"><x-filament::badge
                                 color="success">{{ $item['quantity'] }}</x-filament::badge></td>
                           <td class="px-4 py-3"><x-filament::icon-button
                                 wire:click="removeFromQueue('{{ $key }}')" icon="heroicon-o-trash"
                                 color="danger" tooltip="Remover" /></td>
                        </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
            {{-- Botões de Visualizar e Imprimir (Versão para NPM + Filament v3) --}}


            {{-- OPÇÕES DE IMPRESSÃO (NOVO) --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
               <h4 class="font-semibold text-gray-700 mb-2">Opções de Impressão</h4>
               <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <div>
                     <label for="start_at_position" class="block text-sm font-medium text-gray-700">Iniciar na
                        posição</label>
                     <x-filament::input.wrapper>
                        <x-filament::input.select wire:model.live="start_at_position" id="start_at_position">
                           @foreach ($this->positionOptions as $value => $label)
                              <option value="{{ $value }}">{{ $label }}</option>
                           @endforeach
                        </x-filament::input.select>
                     </x-filament::input.wrapper>
                  </div>
                  <div class="md:col-span-2 self-end">
                     <p class="text-sm text-gray-600">
                        <span class="font-semibold">Total de etiquetas a imprimir:</span>
                        <x-filament::badge color="info" size="lg">
                           {{ collect($printQueue)->sum('quantity') }}
                        </x-filament::badge>
                     </p>
                  </div>
               </div>
            </div>

            {{-- BOTÕES CORRIGIDOS --}}
            <div class="mt-4 flex justify-end gap-4"
               x-data="{
                   print() {
                       // Pega o conteúdo da área de impressão
                       const printableContent = document.getElementById('printableArea').innerHTML;
               
                       // Pega a URL do CSS do Filament para manter o estilo
               
                       // Abre uma nova janela para impressão
                       const printWindow = window.open('', '', 'height=800,width=1200');
               
                       // Escreve o conteúdo na nova janela
                       printWindow.document.write('<html><head><title>Impressão de Etiquetas</title>');
                       printWindow.document.write('</head><body>');
                       printWindow.document.write(printableContent);
                       printWindow.document.write('</body></html>');
               
                       printWindow.document.close();
               
                       // Espera um instante para o conteúdo carregar e então imprime
                       setTimeout(() => {
                           printWindow.focus();
                           printWindow.print();
                           printWindow.close();
                       }, 250); // Um pequeno delay para garantir que tudo carregue
                   }
               }">
               <button type="button" @click="print()" class="fi-btn fi-btn-color-primary fi-btn-size-md">
                  Visualizar
               </button>
               <button type="button" @click="print()" class="fi-btn fi-btn-color-success fi-btn-size-md">
                  Imprimir
               </button>
            </div>

         </x-filament::section>
      @endif
      </div>
   </div>
   {{-- Flash Messages e a primeira parte da UI (inalterada) --}}
   @if (session()->has('success'))
      <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg border border-green-400" role="alert">
         {{ session('success') }}
      </div>
   @endif
   @if (session()->has('error'))
      <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg border border-red-400" role="alert">
         {{ session('error') }}
      </div>
   @endif

   <div class="space-y-6">
      {{-- 1. Seleção do Grupo de Etiquetas --}}




      
   </div>

   {{-- Modal para Seleção de Lote --}}
   @if ($showBatchModal)
      <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
         x-data="{ show: @entangle('showBatchModal') }"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;" {{-- Evita piscar na tela --}}>
         <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg" @click.away="$wire.closeModal()">
            <h3 class="text-lg font-semibold mb-4">
               Adicionar Produto à Fila
               @if ($variationForBatchSelection)
                  <p class="text-sm font-normal text-gray-600">
                     {{ $variationForBatchSelection->product->label_name ?: $variationForBatchSelection->product->comercial_name }}
                  </p>
               @endif
            </h3>
            <div class="space-y-4">
               <div>
                  <label for="batch" class="block text-sm font-medium text-gray-700">Lote</label>
                  <x-filament::input.select wire:model.live="selectedBatchId" id="batch" class="mt-1">
                     <option value="">Selecione um lote</option>
                     @foreach ($this->batchesForSelectedVariation as $batch)
                        <option value="{{ $batch->id }}">
                           {{ $batch->identification }} (Val:
                           {{ $batch->expiration_month }}/{{ $batch->expiration_year }}) -
                           {{ $batch->supplier?->company_name }}
                        </option>
                     @endforeach
                  </x-filament::input.select>
                  @error('selectedBatchId')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
               </div>
               <div>
                  <label for="quantity" class="block text-sm font-medium text-gray-700">Quantidade</label>
                  <x-filament::input type="number" wire:model="quantity" id="quantity" min="1"
                     class="mt-1" />
                  @error('quantity')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
               </div>
            </div>
            <div class="mt-6 flex justify-end gap-4">
               <x-filament::button color="gray" wire:click="closeModal">Cancelar</x-filament::button>
               <x-filament::button wire:click="addToQueue" color="primary">Adicionar à Lista</x-filament::button>
            </div>
         </div>
      </div>
   @endif

   {{-- Lógica de Impressão --}}
   <div id="printableArea" class="absolute -top-full -left-full"
      wire:key="print-area-{{ $start_at_position }}-{{ count($printQueue) }}">

      @if (!empty($printQueue))
         @php
            // 1. Prepara as variáveis GLOBAIS para a impressão
            $firstItem = Arr::first($printQueue);
            $firstVariation = \App\Models\ProductVariation::with('labelGroup')->find($firstItem['variation_id']);
            $labels_per_page = $firstVariation?->labelGroup?->labels_per_page ?? 1;
            $total_labels_in_queue = collect($printQueue)->sum('quantity');

            // 2. Cria um "array plano" de etiquetas para simplificar o loop.
            // Cada item no array representa UMA etiqueta a ser impressa.
            $flatPrintList = [];
            foreach ($printQueue as $item) {
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $flatPrintList[] = $item; // Adiciona o item 'quantity' vezes
                }
            }
         @endphp

         {{-- 3. USA A SUA LÓGICA DE LOOP ANTIGA, alimentada pelos dados da fila --}}
         @for ($current_label_pos = 1; $current_label_pos <= $total_labels_in_queue + $start_at_position - 1; $current_label_pos++)
            @if (($current_label_pos - 1) % $labels_per_page == 0)
               <div
                  class="print-label-page {{ $current_label_pos + $labels_per_page - 1 <= $total_labels_in_queue + $start_at_position - 1 ? 'page-break' : '' }}">
            @endif

            <div class="print-label-container">
               @if ($current_label_pos < $start_at_position)
                  <div class="empty-label">
                     <p></p>
                  </div>
               @else
                  @php
                     // Pega a etiqueta correta do nosso "array plano"
                     $label_index = $current_label_pos - $start_at_position;
                     $currentItem = $flatPrintList[$label_index];

                     // Carrega os dados completos (com cache para performance)
                     $selectedVariation = \App\Models\ProductVariation::with([
                         'product.pictograms',
                         'product.hazardClass',
                         'labelGroup',
                         'unitMeasurement',
                     ])->find($currentItem['variation_id']);
                     $selectedBatch = \App\Models\Batch::find($currentItem['batch_id']);
                     $product = $selectedVariation->product;
                  @endphp

                  {{-- O SEU CÓDIGO DE CONTEÚDO DA ETIQUETA (INTACTO) --}}
                  <div class="product-name">{{ $product->label_name }}</div>

                  <div class="product-info">
                     <p>ONU: {{ $product->un_number }}</p>
                     <p>Classe Risco: {{ $product->hazardClass->class_number }}</p>
                  </div>

                  <div class="product-proportion">
                     @if (!empty($product->proportion))
                        <p>{{ $product->proportion }}</p>
                     @endif
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
                     <p>Validade:
                        {{ $selectedBatch ? $selectedBatch->expiration_month . '/' . $selectedBatch->expiration_year : '' }}
                     </p>
                  </div>

                  {{-- Product pictograms --}}
                  <div class="product-pictograms">
                     @foreach ($product->pictograms as $pictogram)
                        <img src="{{ Storage::url($pictogram->image) }}" alt="Pictograma">
                     @endforeach
                  </div>

                  {{-- Product weight --}}
                  <div class="product-weight">
                     {{ $selectedVariation?->formattedWeight() }}
                     {{ $selectedVariation?->unitMeasurement?->unit_symbol }}
                  </div>

                  {{-- Product barcode --}}
                  <div class="product-barcode">
                     @if ($selectedVariation && $selectedVariation->gtin)
                        <img
                           src="data:image/png;base64,{{ DNS1D::getBarcodePNG($selectedVariation->gtin, 'EAN13', 2, 93, [0, 0, 0], true) }}"
                           alt="barcode" />
                     @endif
                  </div>
               @endif
            </div>

            @if ($current_label_pos % $labels_per_page == 0 || $current_label_pos == $total_labels_in_queue + $start_at_position - 1)
   </div>
   @endif
   @endfor
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

         .page-break {
            page-break-after: always;
         }

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





   @endif
</div>
</div>

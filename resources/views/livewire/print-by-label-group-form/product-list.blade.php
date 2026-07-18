 <div>
    <x-filament::section>

       <x-slot name="heading">2. Selecione os Produtos para Impressão</x-slot>
       @if ($selectedLabelGroupId)
          <div class="mb-4">
             <x-filament::input.wrapper>
                <x-filament::input wire:model.live.debounce.300ms="searchProduct" type="text"
                   placeholder="Digite para filtrar produtos..." />
             </x-filament::input.wrapper>
          </div>
       @endif

       @if ($selectedLabelGroupId)
          <div wire:loading.class="opacity-50" class="space-y-2">
             @forelse($this->availableProductVariations as $variation)
                <div class="flex items-center justify-between p-3 bg-zinc-100 rounded-lg border border-zinc-200">
                   <div class=>
                      <div class="flex items-center gap-2">
                         <p class="font-semibold text-gray-800">
                            {{  $variation->product->comercial_name }}</p>
                         <p class="text-sm text-gray-600">
                            {{ $variation->formattedWeight() }} {{ $variation->unitMeasurement?->unit_symbol }}
                         </p>
                      </div>

                      <p class="text-sm">{{ $variation->product->label_name ?: $variation->product->internal_name }}</p>
                   </div>

                   <x-filament::button wire:click="openBatchModal({{ $variation->id }})" icon="heroicon-o-plus">
                      
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
       @else
          <div>Selecione primeiro um grupo de etiquetas</div>
       @endif

         

    </x-filament::section>
 </div>

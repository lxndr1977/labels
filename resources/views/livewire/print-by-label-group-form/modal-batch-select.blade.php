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
         <div class="space-y-6">
            <div>
               <label for="batch" class="block text-sm font-medium text-gray-700 mb-2">Lote</label>
               <x-filament::input.wrapper>

                  <x-filament::input.select wire:model="selectedBatchId" id="batch" class="mt-1">
                     <option value="">Selecione um lote</option>
                     @foreach ($this->batchesForSelectedVariation as $batch)
                        <option value="{{ $batch->id }}">
                           {{ $batch->identification }} (Val:
                           {{ $batch->expiration_month }}/{{ $batch->expiration_year }}) -
                           {{ $batch->supplier?->company_name }}
                        </option>
                     @endforeach
                  </x-filament::input.select>
               </x-filament::input.wrapper>

                  @error('selectedBatchId')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror

            </div>
            <div>
               <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantidade</label>
               <x-filament::input.wrapper>

                  <x-filament::input type="number" wire:model.live="quantity" id="quantity" min="1"
                     class="mt-1" />
                  @error('quantity')
                     <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                  @enderror
               </x-filament::input.wrapper>
            </div>
         </div>

         <div class="mt-6 flex justify-end gap-4">
            <x-filament::button color="gray" wire:click="closeModal">Cancelar</x-filament::button>
            <x-filament::button wire:click="addToQueue" color="primary">Adicionar à Lista</x-filament::button>
         </div>
      </div>
   </div>
@endif

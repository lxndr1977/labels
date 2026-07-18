{{-- 3. Lista de Impressão --}}

<div class="sticky top-20 self-start">


<x-filament::section>
   <x-slot name="heading">3. Lista de Impressão</x-slot>
   


   @if (!empty($printQueue))

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
         <x-filament::button outlined wire:click="clearQueue()" icon="heroicon-o-x-circle" color="gray">Limpar</x-filament::button>
         <x-filament::button  @click="print()" icon="heroicon-o-printer">Imprimir</x-filament::button>

      </div>
   @endif

</x-filament::section>
</div>

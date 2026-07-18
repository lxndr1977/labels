@if ($this->selectedLabelGroupImage)
   <div class="mb-6">
      <x-filament::section>
         <x-slot name="heading">Rótulo</x-slot>
         <img src="{{ $this->selectedLabelGroupImage }}" alt="Imagem do Grupo de Etiquetas" class="">
      </x-filament::section>
   </div>
@endif

<div class="mb-6">
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


</div>





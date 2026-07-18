<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
@php
    $pictograms = \App\Models\Pictogram::all()->keyBy('id');
@endphp

<div class="space-y-2">
    @foreach ($options() as $id => $description)
        @php
            $pictogram = $pictograms->get($id);
        @endphp

        @if ($pictogram)
            <div class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    id="pictogram-{{ $id }}"
                    name="{{ $getName() }}[]"
                    value="{{ $id }}"
                    {{ in_array($id, $getState() ?? []) ? 'checked' : '' }}
                    class="fi-checkbox-input rounded-sm border-none bg-white shadow-xs ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50 dark:text-primary-500 dark:ring-white/20 dark:checked:bg-primary-500 dark:focus:ring-primary-500 dark:checked:focus:ring-primary-400/50 dark:disabled:ring-white/10"
                    {{ $isDisabled() ? 'disabled' : '' }}
                    wire:model="{{ $getStatePath() }}"
                >
                <label for="pictogram-{{ $id }}" class="flex items-center cursor-pointer">
                    <img src="{{ $pictogram->getImageUrlAttribute() }}" alt="{{ $description }}" class="w-8 h-8 mr-2">
                    {{ $description }}
                </label>
            </div>
        @endif
    @endforeach
</div>

</x-dynamic-component>

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $options = $field->options();
        $selectedOption = $getState(); // Valor atual da opção selecionada
        $selectedImage = $options[$selectedOption]['image'] ?? ''; // Imagem do pacote selecionado
        $isDisabled = $field->isDisabled(); // Verifica se o campo está desativado
        $isEditMode = $selectedOption !== null; // Verifica se estamos no modo de edição
        $selectedLabel = $isEditMode ? ($options[$selectedOption]['label'] ?? 'Select Package') : 'Select Package';
        $selectedDescription = $isEditMode ? ($options[$selectedOption]['description'] ?? '') : '';
    @endphp

    <div x-data="{
        selectedOption: @entangle($getStatePath()),
        selectedImage: '{{ Storage::url($selectedImage) }}', // Carrega a imagem inicial
        dropdownOpen: false,
        $options: @js($options),
        isDisabled: @js($isDisabled),
        selectedLabel: @js($selectedLabel),
        selectedDescription: @js($selectedDescription),
        updateImage() {
            const option = this.$options[this.selectedOption];
            if (option) {
                this.selectedImage = option.image ? '{{ Storage::url('') }}' + option.image : '';
                this.selectedLabel = option.label || 'Select Package';
                this.selectedDescription = option.description || '';
            } else {
                this.selectedImage = '';
                this.selectedLabel = 'Select Package';
                this.selectedDescription = '';
            }
        },
        toggleDropdown() {
            if (!this.isDisabled) {
                this.dropdownOpen = !this.dropdownOpen;
            }
        },
        selectOption(option) {
            if (!this.isDisabled) {
                this.selectedOption = option;
                this.updateImage();
                this.dropdownOpen = false;
            }
        }
    }" x-init="{
        updateImage(); // Atualiza a imagem ao inicializar
        $watch('selectedOption', updateImage); // Atualiza a imagem e o texto quando a opção muda
    }">
        <button class="dropbtn"
                @click.stop.prevent="toggleDropdown()"
                :class="{ 'disabled': isDisabled }">
            <span x-text="selectedLabel"></span>
            <img :src="selectedImage" alt="" class="w-8 h-8 ml-2" x-show="selectedImage">
        </button>
        <div x-show="dropdownOpen" class="dropdown-content" @click.away="dropdownOpen = false">
            @foreach ($options as $value => $option)
                <div class="dropdown-item"
                     @click.stop.prevent="selectOption('{{ $value }}')">
                    <img src="{{ Storage::url($option['image']) }}" alt="{{ $option['label'] }}" class="dropdown-image">
                    <span>{{ $option['label'] }}</span>
                </div>
            @endforeach
        </div>
        <!-- Exibindo a descrição do pacote selecionado -->
        <div x-show="selectedDescription" class="package-description">
            <p x-text="selectedDescription"></p>
        </div>
    </div>

    <!-- Styles for Dropdown -->
    <style>
        .dropbtn {
            background-color: #f9f9f9;
            color: black;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            cursor: pointer;
            display: flex;
            align-items: center;
            border-radius: 4px;
            width: 100%; /* Ajustado para ocupar toda a largura disponível */
            text-align: left; /* Alinhamento do texto à esquerda */
        }
        .dropbtn.disabled {
            cursor: not-allowed;
            background-color: #e0e0e0;
            color: #a0a0a0;
        }
        .dropdown-content {
            position: absolute;
            background-color: #fff;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            overflow: hidden; /* Adiciona para esconder bordas externas */
        }
        .dropdown-item {
            padding: 12px 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .dropdown-item:hover {
            background-color: #ddd;
        }
        .dropdown-image {
            width: 30px;
            height: 30px;
            margin-right: 8px;
            border-radius: 50%;
        }
        .package-description {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
        }
    </style>
</x-dynamic-component>

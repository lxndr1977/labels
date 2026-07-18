<div>
    {{-- Success is as dangerous as failure. --}}

    <h3>Dados do Formulário:</h3>
    <ul>
        @foreach($formData as $key => $value)
            <li>{{ $key }}: {{ is_array($value) ? json_encode($value) : $value }}</li>
            
        @endforeach
    </ul>


    @if (isset($formData) && is_array($formData) && count($formData) > 0)
    <ul>
            @foreach($formData['products'] as $key => $product)
                @if (isset($product['product_id']))
                <li>
                    <strong>Produto ID:</strong> {{ $product['product_id'] }}<br>
                    <strong>Nome do Rótulo:</strong> {{ $product['label_name'] }}<br>
                    <strong>Lote ID:</strong> {{ $product['batch_id'] }}<br>
                    <strong>Peso ID:</strong> {{ $product['weight_id'] }}<br>
                    <strong>Quantidade:</strong> {{ $product['quantity'] ?? 'N/A' }}<br>
                    <strong>GTIN:</strong> {{ $product['gtin'] ?? 'N/A' }}<br>
                    <strong>Peso com Unidade:</strong> {{ $product['weight_with_unit'] ?? 'N/A' }}<br>
                    <strong>Mês de Expiração:</strong> {{ $product['expiration_month'] }}<br>
                    <strong>Ano de Expiração:</strong> {{ $product['expiration_year'] }}<br>
                </li>
                @endif
            @endforeach
        </ul>
    @else
        <p>Nenhum produto encontrado.</p>
    @endif

    <div class="no-print">
         <!-- Print button -->
         <x-filament::button 
            type="button" 
            x-on:click="window.print()">
            Imprimir rótulo
        </x-filament::button>
    </div>

</div>
 
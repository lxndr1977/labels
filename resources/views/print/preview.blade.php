<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview - Impressão de Etiquetas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        
        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .preview-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .labels-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .label-preview {
            border: 2px dashed #007bff;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            min-height: 150px;
            position: relative;
        }
        
        .label-preview h4 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 14px;
            font-weight: bold;
        }
        
        .label-info {
            font-size: 12px;
            line-height: 1.4;
            color: #666;
        }
        
        .label-info strong {
            color: #333;
        }
        
        .pictograms-preview {
            margin: 10px 0;
        }
        
        .pictogram-mini {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
            border: 1px solid #ddd;
        }
        
        .btn {
            padding: 12px 24px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        .stats {
            background: #e9ecef;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }
        
        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Preview da Impressão</h1>
        <p>Grupo de Etiquetas: <strong>{{ $labelGroup->name }}</strong></p>
        
        <div class="stats">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ count($processedItems) }}</div>
                    <div class="stat-label">Total de Etiquetas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ collect($processedItems)->groupBy('product.id')->count() }}</div>
                    <div class="stat-label">Produtos Únicos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ collect($processedItems)->groupBy('batch.id')->count() }}</div>
                    <div class="stat-label">Lotes Diferentes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ ceil(count($processedItems) / ($labelGroup->labels_per_page ?? 12)) }}</div>
                    <div class="stat-label">Páginas Estimadas</div>
                </div>
            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('print.execute') }}" class="btn btn-primary">
                🖨️ Confirmar e Imprimir
            </a>
            <button onclick="history.back()" class="btn btn-secondary">
                ↩️ Voltar e Editar
            </button>
        </div>
    </div>

    <div class="preview-container">
        <h3>Preview das Etiquetas (primeiras 20)</h3>
        
        <div class="labels-grid">
            @foreach(array_slice($processedItems, 0, 20) as $index => $item)
            <div class="label-preview">
            <div class="label-preview">
                <h4>Etiqueta #{{ $index + 1 }}</h4>
                
                <div class="label-info">
                    <strong>{{ $item['label_name'] }}</strong><br>
                    <strong>Peso:</strong> {{ $item['weight'] }}<br>
                    <strong>Lote:</strong> {{ $item['batch']->identification }}<br>
                    <strong>Validade:</strong> {{ $item['batch']->expiration_month }}/{{ $item['batch']->expiration_year }}<br>
                    
                    @if($item['supplier_name'])
                        <strong>Fornecedor:</strong> {{ $item['supplier_name'] }}<br>
                    @endif
                    
                    @if($item['product']->signal_word)
                        <strong>Palavra-sinal:</strong> {{ $item['product']->signal_word }}<br>
                    @endif
                    
                    @if($item['product']->un_number)
                        <strong>UN:</strong> {{ $item['product']->un_number }}<br>
                    @endif
                    
                    @if($item['variation']->gtin)
                        <strong>GTIN:</strong> {{ $item['variation']->gtin }}<br>
                    @endif
                    
                    @if($item['product']->pictograms->count() > 0)
                        <div class="pictograms-preview">
                            <strong>Pictogramas:</strong><br>
                            @foreach($item['product']->pictograms as $pictogram)
                                <img src="{{ asset('storage/' . $pictogram->image) }}" 
                                     alt="{{ $pictogram->name }}" 
                                     class="pictogram-mini"
                                     title="{{ $pictogram->name }}">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
            
            @if(count($processedItems) > 20)
                <div class="label-preview" style="display: flex; align-items: center; justify-content: center; background: #fff3cd; border-color: #ffeaa7;">
                    <div style="text-align: center; color: #856404;">
                        <strong>+ {{ count($processedItems) - 20 }} etiquetas adicionais</strong><br>
                        <small>Serão impressas junto com estas</small>
                    </div>
                </div>
            @endif
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 4px;">
            <p><strong>Configuração da Impressão:</strong></p>
            <p>Formato: {{ $labelGroup->page_size ?? 'A4' }} | 
               Orientação: {{ $labelGroup->page_orientation ?? 'Portrait' }} | 
               Etiquetas por página: {{ $labelGroup->labels_per_page ?? 12 }}</p>
            <p>Tamanho da etiqueta: {{ $labelGroup->label_width ?? 70 }}mm x {{ $labelGroup->label_height ?? 37 }}mm</p>
        </div>
    </div>
</body>
</html>
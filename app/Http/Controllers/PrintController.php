<?php

namespace App\Http\Controllers;

use App\Models\LabelGroup;
use App\Models\Product;
use App\Models\Batch;
use App\Models\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PrintController extends Controller
{
    public function execute(Request $request)
    {
        $printData = session('print_data');
        
        if (!$printData) {
            return redirect()->back()->with('error', 'Dados de impressão não encontrados.');
        }

        // Busca o grupo de etiquetas
        $labelGroup = LabelGroup::find($printData['label_group_id']);
        
        if (!$labelGroup) {
            return redirect()->back()->with('error', 'Grupo de etiquetas não encontrado.');
        }

        // Processa os itens para impressão
        $processedItems = [];
        
        foreach ($printData['items'] as $item) {
            $product = Product::with(['pictograms', 'hazardClass'])->find($item['product_id']);
            $batch = Batch::with('supplier')->find($item['batch_id']);
            $variation = ProductVariation::where('product_id', $item['product_id'])
                                       ->where('label_group_id', $printData['label_group_id'])
                                       ->with(['package', 'unitMeasurement'])
                                       ->first();

            if ($product && $batch && $variation) {
                // Cria múltiplas cópias baseado na quantidade
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $weight = method_exists($variation, 'formattedWeight') 
                        ? $variation->formattedWeight() 
                        : $variation->weight;
                    
                    $unitAbbr = $variation->unitMeasurement 
                        ? $variation->unitMeasurement->abbreviation 
                        : '';
                    
                    $processedItems[] = [
                        'product' => $product,
                        'batch' => $batch,
                        'variation' => $variation,
                        'weight' => $weight . ' ' . $unitAbbr,
                        'label_name' => $product->label_name ?: $product->comercial_name,
                        'batch_info' => $batch->identification . ' - ' . $batch->expiration_month . '/' . $batch->expiration_year,
                        'supplier_name' => $batch->supplier ? $batch->supplier->name : '',
                    ];
                }
            }
        }

        // Limpa os dados da sessão
        session()->forget('print_data');

        // Retorna a view de impressão
        return view('print.labels', compact('labelGroup', 'processedItems'));
    }

    public function preview(Request $request)
    {
        $printData = session('print_data');
        
        if (!$printData) {
            return redirect()->back()->with('error', 'Dados de impressão não encontrados.');
        }

        // Similar ao execute, mas retorna uma preview
        $labelGroup = LabelGroup::find($printData['label_group_id']);
        $processedItems = [];
        
        foreach ($printData['items'] as $item) {
            $product = Product::with(['pictograms', 'hazardClass'])->find($item['product_id']);
            $batch = Batch::with('supplier')->find($item['batch_id']);
            $variation = ProductVariation::where('product_id', $item['product_id'])
                                       ->where('label_group_id', $printData['label_group_id'])
                                       ->with(['package', 'unitMeasurement'])
                                       ->first();

            if ($product && $batch && $variation) {
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $weight = method_exists($variation, 'formattedWeight') 
                        ? $variation->formattedWeight() 
                        : $variation->weight;
                    
                    $unitAbbr = $variation->unitMeasurement 
                        ? $variation->unitMeasurement->abbreviation 
                        : '';
                        
                    $processedItems[] = [
                        'product' => $product,
                        'batch' => $batch,
                        'variation' => $variation,
                        'weight' => $weight . ' ' . $unitAbbr,
                        'label_name' => $product->label_name ?: $product->comercial_name,
                        'batch_info' => $batch->identification . ' - ' . $batch->expiration_month . '/' . $batch->expiration_year,
                        'supplier_name' => $batch->supplier ? $batch->supplier->name : '',
                    ];
                }
            }
        }

        return view('print.preview', compact('labelGroup', 'processedItems'));
    }
}
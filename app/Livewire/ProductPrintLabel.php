<?php

namespace App\Livewire;

use Exception;
use Livewire\Component;

use Filament\Schemas\Schema;
use App\Services\BarcodeService;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Hamcrest\Type\IsInteger;

class ProductPrintLabel extends Component implements HasSchemas
{
   use InteractsWithSchemas;

   public $product;
   public $batch;
   public $product_variation;
   public $selectedBatch;
   public $selectedVariation;
   public $start_at_position = 1;
   public $total_labels = 1;

   protected $barcodeService;

   public function productSchema(Schema $schema): Schema
   {
      return $schema
         ->components([
            // Select de Variação

            Grid::make()->components([

               Select::make('product_variation')
                  ->label('Variação do Produto')
                  ->options($this->getVariationOptions())
                  ->reactive()
                  ->afterStateUpdated(function ($state, callable $set) {
                     // Limpa a posição quando a variação muda
                     $set('start_at_position', 1);
                     // Atualiza a variação selecionada
                     $this->product_variation = $state;
                     $this->getVariation();
                  }),

               // Select de Lote
               Select::make('batch')
                  ->label('Lote')
                  ->options($this->product->batches()->pluck('identification', 'id'))
                  ->preload()
                  ->reactive()
                  ->afterStateUpdated(function ($state) {
                     $this->batch = $state;
                     $this->getBatch();
                  }),
               // Select de Posição (baseado na variação selecionada)
               Select::make('start_at_position')
                  ->label('Posição Inicial')
                  ->options(function (callable $get) {
                     return $this->getPositionOptions($get('product_variation'));
                  })
                  ->default(1),

               // Input para total de etiquetas
               TextInput::make('total_labels')
                  ->label('Total de Etiquetas')
                  ->numeric()
                  ->default(1)
                  ->minValue(1)
                  ->reactive()
                  ->afterStateUpdated(function ($state) {
                     // $this->total_labels = $state;
                     $this->updatedTotalLabels();
                  }),
            ])->columns(4)
         ]);
   }

   private function getVariationOptions()
   {
      return $this->product->variations()
         ->with('unitMeasurement')
         ->get()
         ->mapWithKeys(function ($variation) {
            return [
               $variation->id => $variation->formattedWeight() . ' ' . $variation->unitMeasurement->unit_symbol
            ];
         });
   }

   private function getPositionOptions($variationId)
   {
      if (!$variationId) {
         return [1 => 'Posição 1'];
      }

      $variation = $this->product->variations()
         ->with('labelGroup')
         ->find($variationId);

      if (!$variation || !$variation->labelGroup || !$variation->labelGroup->labels_per_page) {
         return [1 => 'Posição 1'];
      }

      $options = [];
      for ($i = 1; $i <= $variation->labelGroup->labels_per_page; $i++) {
         $options[$i] = "Posição {$i}";
      }

      return $options;
   }

   public function __construct()
   {
      $this->barcodeService = app(BarcodeService::class);
   }

   public function mount($product = null)
   {
      $this->product = $product;
      $this->updatedTotalLabels();
   }

   public function render()
   {
      return view('livewire.product-print-label', [
         'products' => $this->product
      ]);
   }

   public function updatedBatch()
   {
      $this->getBatch();
   }

   public function updatedProductVariation()
   {
      $this->getVariation();
   }

   public function handleTotalLabelsBlur()
   {
      // Lógica específica para quando o campo de labels perde o foco
   }

   public function updatedTotalLabels()
   {
      // Lógica para atualizar a visualização quando total_labels muda
   }

   public function getBatch()
   {
      if ($this->product && $this->product->batches) {
         $this->selectedBatch = $this->product->batches->firstWhere('id', $this->batch);
      } else {
         $this->selectedBatch = null;
      }
   }

   public function getVariation()
   {
      if ($this->product && $this->product->variations) {
         $this->selectedVariation = $this->product->variations->firstWhere('id', $this->product_variation);
      } else {
         $this->selectedVariation = null;
      }
   }

   public function updateBatch($newValue)
   {
      $this->batch = $newValue;
   }

   public function getBarcode($gtin)
   {
      try {
         // Gera o código de barras como Base64
         if (ctype_digit($gtin)) {
            return $this->barcodeService->generate($gtin, 'ean13', 2, 50, true);
         }
      } catch (Exception $e) {
         // Retorna uma imagem placeholder em caso de erro
         return 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('images/placeholder.png')));
      }
   }
}

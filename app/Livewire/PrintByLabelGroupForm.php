<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\LabelGroup;
use App\Models\ProductVariation;
use Livewire\Component;
use Livewire\WithPagination;

use Filament\Notifications\Notification;


class PrintByLabelGroupForm extends Component
{
   use WithPagination;

   public $selectedLabelGroupId = null;
   public $searchProduct = '';
   public array $printQueue = [];

   //-- Propriedades para o Modal de Lote
   public ?ProductVariation $variationForBatchSelection = null;
   public $selectedBatchId = null;
   public $quantity = 1;
   public bool $showBatchModal = false;
   //--

   public $selectedLabelGroupImage;

   public int $start_at_position = 1; // Adicionado!


   public function getSelectedLabelGroupImageProperty()
   {
      if (!$this->selectedLabelGroupId) {
         return null;
      }

      $labelGroup = LabelGroup::find($this->selectedLabelGroupId);

      if (!$labelGroup) {
         return null;
      }

      $this->selectedLabelGroupImage =  asset('storage/' . $labelGroup->image);
   }


   public function updatedStartAtPosition()
   {
      $this->dispatch('$refresh');
   }


   public function getLabelGroupsProperty()
   {
      return LabelGroup::select(['id', 'name'])->orderBy('name')->get();
   }

   public function getAvailableProductVariationsProperty()
   {
      if (!$this->selectedLabelGroupId) {
         // Retorna uma coleção de paginação vazia para evitar erros na view
         return new \Illuminate\Pagination\LengthAwarePaginator([], 0, 10);
      }

      return ProductVariation::with([
         'product:id,comercial_name,internal_name,label_name',
         'package:id,description',
         'unitMeasurement:id,unit_symbol',
      ])
         ->where('label_group_id', $this->selectedLabelGroupId)
         ->whereHas('product', function ($query) {
            $query->where('is_active', true)
               ->when($this->searchProduct, function ($query, $search) {
                  $searchTerm = '%' . $search . '%';
                  $query->where(function ($q) use ($searchTerm) {
                     $q->where('comercial_name', 'like', $searchTerm)
                        ->orWhere('label_name', 'like', $searchTerm);
                  });
               });
         })
         ->paginate(10);
   }

   public function getBatchesForSelectedVariationProperty()
   {
      if (!$this->variationForBatchSelection) {
         return collect();
      }
      return Batch::where('product_id', $this->variationForBatchSelection->product_id)
         ->with('supplier:id,company_name')
         // ->orderBy('identification')
         ->get();
   }

   public function updatedSelectedLabelGroupId()
   {
      $this->resetPage();
      $this->searchProduct = '';
      $this->printQueue = [];
      $this->start_at_position = 1; // Reset para posição 1

      $this->getSelectedLabelGroupImageProperty();
   }

   public function updatedSearchProduct()
   {
      $this->resetPage();
   }

   public function openBatchModal($variationId)
   {
      $this->variationForBatchSelection = ProductVariation::with('product')->find($variationId);
      $this->quantity = 1;
      $this->selectedBatchId = null;
      $this->showBatchModal = true;
   }

   public function getPositionOptionsProperty()
   {
      if (!$this->selectedLabelGroupId) {
         return [1 => 'Posição 1'];
      }

      $labelGroup = LabelGroup::find($this->selectedLabelGroupId);

      if (!$labelGroup || !$labelGroup->labels_per_page) {
         return [1 => 'Posição 1'];
      }

      $options = [];
      for ($i = 1; $i <= $labelGroup->labels_per_page; $i++) {
         $options[$i] = "Posição {$i}";
      }

      return $options;
   }


   public function addToQueue()
   {

   //  if (!$this->showBatchModal || !$this->variationForBatchSelection) {
   //      return;
   //  }

      $this->validate([
         'selectedBatchId' => 'required',
         'quantity' => 'required|integer|min:1',
      ], [
         'selectedBatchId.required' => 'É obrigatório selecionar um lote.',
         'quantity.min' => 'A quantidade deve ser de no mínimo 1.',
      ]);

      $variation = $this->variationForBatchSelection;
      $batch = Batch::with('supplier:id,company_name')->find($this->selectedBatchId);

      $queueKey = $variation->id . '-' . $batch->id;


      if (isset($this->printQueue[$queueKey])) {
         $this->printQueue[$queueKey]['quantity'] = $this->quantity;
         // Notification::make()
         //    ->title('Quantidade atualizada na lista!')
         //    ->success()
         //    ->send();
      } else {
         $this->printQueue[$queueKey] = [
            'variation_id' => $variation->id,
            'product_id' => $variation->product->id,
            'batch_id' => $batch->id,
            'quantity' => $this->quantity,
            'product_name' => $variation->product->label_name ?: $variation->product->comercial_name,
            'batch_identification' => $batch->identification,
            'supplier_name' => $batch->supplier?->company_name ?? 'N/A',
            'weight' => $variation->formattedWeight() . ' ' . $variation->unitMeasurement?->unit_symbol . ($variation->package ? ' (' . $variation->package->description . ')' : ''),
            'expiration' => $batch->expiration_month . '/' . $batch->expiration_year,
         ];
         // Notification::make()
         //    ->title('Produto adicionado à lista!')
         //    ->success()
         //    ->seconds(2)
         //    ->send();
      }

      $this->closeModal();

   }

   public function removeFromQueue($queueKey)
   {
      unset($this->printQueue[$queueKey]);
      // Notification::make()
      //    ->title('Item removido da lista')
      //    ->success()
      //    ->send();
   }

   public function clearQueue()
   {
      $this->printQueue = [];
      // Notification::make()
      //    ->title('Lista de impressão limpa')
      //    ->success()
      //    ->send();
   }

   public function closeModal()
   {
      $this->showBatchModal = false;
      $this->reset('variationForBatchSelection', 'selectedBatchId', 'quantity');
   }

   public function render()
   {
      return view('livewire.print-by-label-group-form.index');
   }
}

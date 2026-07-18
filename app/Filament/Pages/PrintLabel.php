<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Forms;
use App\Models\Batch;
use App\Models\Product;
use App\Models\LabelGroup;
use App\Models\ProductVariation;
use Filament\Pages\Page;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Forms\Set;

class PrintLabel extends Page
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.print-label';

    protected static bool $isDiscovered = false;

    public ?array $data = null;

    public $labelGroup = [];

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function print($value)
    {
        $this->dispatchBrowserEvent('print'); // Dispara o evento de impressão
    }

    public function updatedData($value)
    {
        $this->dispatch('form-updated', ['formData' => $this->data]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('label_group_id')
                    ->options(LabelGroup::all()->pluck('name', 'id')->toArray())
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, Get $get): void {
                        $set('products', []); 
                        $set('labelGroup', LabelGroup::find($get('label_group_id'))); 
                    }),

                Repeater::make('products')
                    ->schema([
                        Select::make('product_id')
                            ->options(Product::all()->pluck('comercial_name', 'id')->toArray())
                            ->searchable()
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('batch_id', null);
                                $set('weight_id', null);
                                $set('gtin', null);
                                $set('weight_with_unit', null);
                                $set('expiration_month', null);
                                $set('expiration_year', null);

                                // Obter o produto selecionado
                                $product = Product::find($state);
                                if ($product) {
                                    $set('label_name', $product->label_name);
                                    $set('un_number', $product->un_number);
                                    $set('hazard_class_id', $product->hazardClass->class_number); 
                                    $set('pictograms', $product->pictograms->map->getImageUrlAttribute()->toArray()); 
                                }
                            }),

                        Select::make('batch_id')
                            ->options(fn (Get $get): array => 
                                $get('product_id') ? 
                                    Batch::where('product_id', $get('product_id'))->pluck('identification', 'id')->toArray() : 
                                    []
                            )
                            ->searchable()
                            ->live(onBlur: true)
                            ->required()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $batch = Batch::find($state);
                                        if ($batch) {
                                            $set('identification', $batch->identification);
                                            $set('expiration_month', $batch->expiration_month);
                                            $set('expiration_year', $batch->expiration_year);
                                        }
                                    }),

                        Select::make('weight_id')
                            ->options(fn (Get $get): array => 
                                $get('product_id') ? 
                                    ProductVariation::where('product_id', $get('product_id'))
                                        ->where('label_group_id', $get('../../label_group_id'))
                                        ->pluck('weight', 'id')
                                        ->toArray() : 
                                    [])
                            ->live(onBlur: true)
                            ->searchable()
                                    ->required()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $weight = ProductVariation::find($state);
                                        if ($weight) {
                                            $set('gtin', $weight->gtin);
                                            $unitMeasurementSymbol = $weight->unitMeasurement->symbol ?? '';
                                            $set('weight_with_unit', $weight->formattedWeight() . ' ' . $unitMeasurementSymbol);
                                        }
                                    }),

                            TextInput::make('quantity')
                                ->live(onBlur: true)
                                ->label('Quantidade')
                                        ->numeric()
                                        ->afterStateUpdated(fn ($state, $livewire) => $livewire->updatedData($state)),
                                ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->deleteAction(
                        function (Action $action) {
                            return $action
                                ->requiresConfirmation()
                                ->modalDescription('Are you sure you want to delete this item? This action cannot be undone.')
                                    ->before(function (callable $get, callable $set, $state, array $arguments, $livewire) {
                                        // Obtenha o array de produtos atual
                                        $currentItems = $get('products');

                                        // Valor do item a ser removido
                                        $itemToRemove = $arguments['item'];

                                        // Debug: Mostra o item e os produtos atuais
                                        // dd("Item to remove: " . $itemToRemove, $currentItems);

                                        // Verifique se o item existe no array
                                        if (isset($currentItems[$itemToRemove])) {
                                            unset($currentItems[$itemToRemove]); // Remove o item
                                            $set('products', $currentItems); // Atualiza o estado com o array atualizado

                                            // Debug: Verifica se a remoção foi bem-sucedida
                                            // dd("Item removed: " . $itemToRemove, $currentItems);
                                        } else {
                                            dd("Item not found for removal: " . $itemToRemove);
                                        }
                                        // dd($currentItems);

                                        $livewire->updatedData($state);
                                    });


                        }
                    )

            ])
            ->statePath('data');  // Bind form state to the `data` property
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
                ->label('Imprimir')
                ->action(fn () => $this->print(null)), // Chama a função de impressão
        ];
    }
}

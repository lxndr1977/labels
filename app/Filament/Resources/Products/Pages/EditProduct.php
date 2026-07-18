<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Products\ProductResource;
use App\Filament\Resources\Products\Schemas\Schemas\ProductForm;
use BackedEnum;

class EditProduct extends EditRecord
{
   protected static string $resource = ProductResource::class;

   public function hasCombinedRelationManagerTabsWithContent(): bool
   {
      return true;
   }

   public function getContentTabLabel(): ?string
   {
      return 'Produto';
   }

   public function getContentTabIcon(): string|BackedEnum|null
   {
      return 'heroicon-o-cube';
   }

   protected function getRedirectUrl(): string
   {
      return $this->previousUrl ?? $this->getResource()::getUrl('index');
   }
}

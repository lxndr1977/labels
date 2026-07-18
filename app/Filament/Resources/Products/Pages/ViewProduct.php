<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\Products\ProductResource;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class ViewProduct extends ViewRecord
{
   protected static string $resource = ProductResource::class;

   public function hasCombinedRelationManagerTabsWithContent(): bool
   {
      return true;
   }

   protected function getHeaderActions(): array
   {
      return [
         EditAction::make()
         ->icon(Heroicon::OutlinedPencilSquare)
      ];
   }

   public function getContentTabLabel(): ?string
   {
      return 'Produto';
   }

   public function getContentTabIcon(): string|BackedEnum|null
   {
      return 'heroicon-o-cube';
   }
}

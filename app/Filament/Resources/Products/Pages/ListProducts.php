<?php

namespace App\Filament\Resources\Products\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use App\Filament\Resources\Products\ProductResource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Icons\Heroicon;

class ListProducts extends ListRecords
{
   protected static string $resource = ProductResource::class;

   public function getTabs(): array
   {
      return [
         'active' => Tab::make()
            ->label('Ativos')
            ->icon('heroicon-o-check-circle')
            ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', true)),

         'inactive' => Tab::make()
            ->label('Inativos')
            ->icon('heroicon-o-x-circle')
            ->modifyQueryUsing(fn(Builder $query) => $query->where('is_active', false)),

         'all' => Tab::make()
            ->label('Todos')
            ->icon('heroicon-o-list-bullet'),
      ];
   }

   protected function getHeaderActions(): array
   {
      return [
         CreateAction::make()
            ->icon(Heroicon::OutlinedPlus),
      ];
   }

   
}

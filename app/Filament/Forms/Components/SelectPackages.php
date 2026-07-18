<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use App\Models\Package;

class SelectPackages extends Field
{
    protected string $view = 'forms.components.select-packages';

    public function options()
    {
        return Package::all()->mapWithKeys(function ($item) {
            return [$item->id => [
                'label' => $item->description,
                'image' => $item->getImageUrlAttribute()
            ]];
        })->toArray();
    }
}

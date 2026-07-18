<?php

namespace App\Filament\Forms\Components;

use App\Models\Pictogram;
use Filament\Forms\Components\Field;

class CheckboxListPictograms extends Field
{
    protected string $view = 'forms.components.checkbox-list-pictograms';

    public function options()
    {
        return Pictogram::all()->mapWithKeys(function ($item) {
            return [$item->id => $item->description];
        });
    }

}
 
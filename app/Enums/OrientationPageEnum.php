<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OrientationPageEnum: string implements HasLabel
{
    case Portrait = 'portrait';
    case Landscape = 'landscape';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Portrait => 'Retrato',
            self::Landscape => 'Paisagem',
        };
    }
   
}
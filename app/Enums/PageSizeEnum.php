<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PageSizeEnum: string implements HasLabel
{
    case A4 = 'A4';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::A4 => 'A4',
        };
    }
}
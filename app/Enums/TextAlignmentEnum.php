<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TextAlignmentEnum: string implements HasLabel
{
    case Left = 'left';
    case Right = 'right';
    case Center = 'center';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Left => 'Esquerda',
            self::Right => 'Direita',
            self::Center => 'Centralizado',
        };
    }
   
}
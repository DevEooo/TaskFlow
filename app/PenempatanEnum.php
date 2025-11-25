<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PenempatanEnum: string implements HasLabel
{
    case GEDUNG_A = 'Nurul Fikri Gedung A';
    case GEDUNG_B = 'Nurul Fikri Gedung B';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
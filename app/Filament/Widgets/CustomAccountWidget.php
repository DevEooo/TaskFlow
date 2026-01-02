<?php

namespace App\Filament\Widgets;

use Filament\Widgets\AccountWidget as BaseAccountWidget;

class CustomAccountWidget extends BaseAccountWidget
{
    protected int|string|array $columnSpan = 'full';

    // Anda bisa mengatur urutan tampilan (defaultnya 10)
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;
}
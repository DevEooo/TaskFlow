<?php

namespace App\Filament\Resources\User\Shifts\Pages;

use App\Filament\Resources\User\Shifts\ShiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShifts extends ListRecords
{
    protected static string $resource = ShiftResource::class;
}

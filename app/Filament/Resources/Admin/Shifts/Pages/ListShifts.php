<?php

namespace App\Filament\Resources\Admin\Shifts\Pages;

use App\Filament\Resources\Admin\Shifts\ShiftsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShifts extends ListRecords
{
    protected static string $resource = ShiftsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

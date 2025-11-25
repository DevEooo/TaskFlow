<?php

namespace App\Filament\Resources\Admin\JadwalShifts\Pages;

use App\Filament\Resources\Admin\JadwalShifts\JadwalShiftResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJadwalShifts extends ListRecords
{
    protected static string $resource = JadwalShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

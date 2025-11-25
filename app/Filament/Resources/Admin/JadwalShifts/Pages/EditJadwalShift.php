<?php

namespace App\Filament\Resources\Admin\JadwalShifts\Pages;

use App\Filament\Resources\Admin\JadwalShifts\JadwalShiftResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalShift extends EditRecord
{
    protected static string $resource = JadwalShiftResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

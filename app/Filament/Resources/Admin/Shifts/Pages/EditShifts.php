<?php

namespace App\Filament\Resources\Admin\Shifts\Pages;

use App\Filament\Resources\Admin\Shifts\ShiftsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditShifts extends EditRecord
{
    protected static string $resource = ShiftsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

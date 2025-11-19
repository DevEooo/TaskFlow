<?php

namespace App\Filament\Resources\Admin\Attendances\Pages;

use App\Filament\Resources\Admin\Attendances\AttendancesResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAttendances extends ViewRecord
{
    protected static string $resource = AttendancesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}


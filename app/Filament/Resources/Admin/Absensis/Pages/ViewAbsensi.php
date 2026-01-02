<?php

namespace App\Filament\Resources\Admin\Absensis\Pages;

use App\Filament\Resources\Admin\Absensis\AbsensiResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAbsensi extends ViewRecord
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

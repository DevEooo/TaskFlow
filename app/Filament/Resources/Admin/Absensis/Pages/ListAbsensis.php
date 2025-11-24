<?php

namespace App\Filament\Resources\Admin\Absensis\Pages;

use App\Filament\Resources\Admin\Absensis\AbsensiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAbsensis extends ListRecords
{
    protected static string $resource = AbsensiResource::class;

    protected function getHeaderActions(): array
    {
        // Admin tidak perlu membuat Absensi manual, tapi boleh jika ingin koreksi
        return [
            Actions\CreateAction::make()->label('Buat Absensi Manual'),
        ];
    }
}
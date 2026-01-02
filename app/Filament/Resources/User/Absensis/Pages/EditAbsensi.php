<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\UserAbsensiResource;
use Filament\Resources\Pages\EditRecord;

class EditAbsensi extends EditRecord
{
    protected static string $resource = UserAbsensiResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

<?php

namespace App\Filament\Resources\User\JadwalKus\Pages;

use App\Filament\Resources\User\JadwalKus\JadwalKuResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditJadwalKu extends EditRecord
{
    protected static string $resource = JadwalKuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

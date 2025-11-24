<?php

namespace App\Filament\Resources\Admin\Tugas\Pages;

use App\Filament\Resources\Admin\Tugas\TugasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTugas extends EditRecord
{
    protected static string $resource = TugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

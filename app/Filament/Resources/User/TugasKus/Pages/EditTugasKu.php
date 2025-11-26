<?php

namespace App\Filament\Resources\User\TugasKus\Pages;

use App\Filament\Resources\User\TugasKus\TugasKuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTugasKu extends EditRecord
{
    protected static string $resource = TugasKuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

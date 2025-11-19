<?php

namespace App\Filament\User\Resources\User\ListTugas\Pages;

use App\Filament\User\Resources\User\ListTugas\ListTugasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditListTugas extends EditRecord
{
    protected static string $resource = ListTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

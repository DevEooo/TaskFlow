<?php

namespace App\Filament\Resources\WorkProofs\Pages;

use App\Filament\Resources\WorkProofs\WorkProofsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditWorkProofs extends EditRecord
{
    protected static string $resource = WorkProofsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

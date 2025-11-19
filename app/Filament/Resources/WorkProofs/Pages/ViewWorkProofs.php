<?php

namespace App\Filament\Resources\WorkProofs\Pages;

use App\Filament\Resources\WorkProofs\WorkProofsResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWorkProofs extends ViewRecord
{
    protected static string $resource = WorkProofsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Admin\WorkProofs\Pages;

use App\Filament\Resources\Admin\WorkProofs\WorkProofsResource;
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


<?php

namespace App\Filament\Resources\WorkProofs\Pages;

use App\Filament\Resources\WorkProofs\WorkProofsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWorkProofs extends ListRecords
{
    protected static string $resource = WorkProofsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

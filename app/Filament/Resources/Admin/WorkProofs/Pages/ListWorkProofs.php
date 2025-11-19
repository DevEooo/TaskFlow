<?php

namespace App\Filament\Resources\Admin\WorkProofs\Pages;

use App\Filament\Resources\Admin\WorkProofs\WorkProofsResource;
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


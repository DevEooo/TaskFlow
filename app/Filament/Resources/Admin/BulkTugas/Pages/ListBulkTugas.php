<?php

namespace App\Filament\Resources\Admin\BulkTugas\Pages;

use App\Filament\Resources\Admin\BulkTugas\BulkTugasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBulkTugas extends ListRecords
{
    protected static string $resource = BulkTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Admin\LogTugas\Pages;

use App\Filament\Resources\Admin\LogTugas\LogTugasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogTugas extends ListRecords
{
    protected static string $resource = LogTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\TaskLogs\Pages;

use App\Filament\Resources\TaskLogs\TaskLogsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskLogs extends ListRecords
{
    protected static string $resource = TaskLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

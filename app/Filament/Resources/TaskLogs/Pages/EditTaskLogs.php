<?php

namespace App\Filament\Resources\TaskLogs\Pages;

use App\Filament\Resources\TaskLogs\TaskLogsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskLogs extends EditRecord
{
    protected static string $resource = TaskLogsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}

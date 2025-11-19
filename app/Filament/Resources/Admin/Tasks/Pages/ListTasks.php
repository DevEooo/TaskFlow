<?php

namespace App\Filament\Resources\Admin\Tasks\Pages;

use App\Filament\Resources\Admin\Tasks\TasksResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TasksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

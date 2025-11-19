<?php

namespace App\Filament\Resources\Admin\Tasks\Pages;

use App\Filament\Resources\Admin\Tasks\TasksResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTasks extends CreateRecord
{
    protected static string $resource = TasksResource::class;
}

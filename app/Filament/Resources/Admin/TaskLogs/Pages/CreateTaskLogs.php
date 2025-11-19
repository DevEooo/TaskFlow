<?php

namespace App\Filament\Resources\Admin\TaskLogs\Pages;

use App\Filament\Resources\Admin\TaskLogs\TaskLogsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskLogs extends CreateRecord
{
    protected static string $resource = TaskLogsResource::class;
}


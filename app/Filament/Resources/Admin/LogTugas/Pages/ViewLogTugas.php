<?php

namespace App\Filament\Resources\Admin\LogTugas\Pages;

use App\Filament\Resources\Admin\LogTugas\LogTugasResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLogTugas extends ViewRecord
{
    protected static string $resource = LogTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

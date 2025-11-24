<?php

namespace App\Filament\Resources\Admin\LogTugas\Pages;

use App\Filament\Resources\Admin\LogTugas\LogTugasResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLogTugas extends EditRecord
{
    protected static string $resource = LogTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

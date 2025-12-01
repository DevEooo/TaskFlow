<?php

namespace App\Filament\Resources\Admin\BulkTugas\Pages;

use App\Filament\Resources\Admin\BulkTugas\BulkTugasResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBulkTugas extends EditRecord
{
    protected static string $resource = BulkTugasResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         DeleteAction::make(),
    //     ];
    // }
}

<?php

namespace App\Filament\Resources\User\ListTugas\Pages;

use App\Filament\Resources\User\ListTugas\ListTugasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListListTugas extends ListRecords
{
    protected static string $resource = ListTugasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

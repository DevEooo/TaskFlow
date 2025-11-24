<?php

namespace App\Filament\Resources\Admin\Permintaan\Pages;

use App\Filament\Resources\Admin\Permintaan\PermintaanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPermintaan extends ListRecords
{
    protected static string $resource = PermintaanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

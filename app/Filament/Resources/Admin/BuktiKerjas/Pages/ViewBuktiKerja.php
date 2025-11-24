<?php

namespace App\Filament\Resources\Admin\BuktiKerjas\Pages;

use App\Filament\Resources\Admin\BuktiKerjas\BuktiKerjaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBuktiKerja extends ViewRecord
{
    protected static string $resource = BuktiKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\Admin\BuktiKerjas\Pages;

use App\Filament\Resources\Admin\BuktiKerjas\BuktiKerjaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBuktiKerja extends EditRecord
{
    protected static string $resource = BuktiKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}

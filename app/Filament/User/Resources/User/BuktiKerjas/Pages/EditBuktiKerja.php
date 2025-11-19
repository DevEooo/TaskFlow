<?php

namespace App\Filament\User\Resources\User\BuktiKerjas\Pages;

use App\Filament\User\Resources\User\BuktiKerjas\BuktiKerjaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBuktiKerja extends EditRecord
{
    protected static string $resource = BuktiKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

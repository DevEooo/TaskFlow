<?php

namespace App\Filament\User\Resources\User\BuktiKerjas\Pages;

use App\Filament\User\Resources\User\BuktiKerjas\BuktiKerjaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBuktiKerjas extends ListRecords
{
    protected static string $resource = BuktiKerjaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

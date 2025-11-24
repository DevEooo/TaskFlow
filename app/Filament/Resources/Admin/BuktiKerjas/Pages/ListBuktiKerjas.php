<?php

namespace App\Filament\Resources\Admin\BuktiKerjas\Pages;

use App\Filament\Resources\Admin\BuktiKerjas\BuktiKerjaResource;
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

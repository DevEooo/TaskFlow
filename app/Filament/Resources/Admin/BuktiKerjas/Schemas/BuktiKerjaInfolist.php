<?php

namespace App\Filament\Resources\Admin\BuktiKerjas\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BuktiKerjaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Admin\Chats\Pages;

use App\Filament\Resources\Admin\Chats\ChatResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChats extends ListRecords
{
    protected static string $resource = ChatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}


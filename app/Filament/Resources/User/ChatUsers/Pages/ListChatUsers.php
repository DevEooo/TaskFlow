<?php

namespace App\Filament\Resources\User\ChatUsers\Pages;

use App\Filament\Resources\User\ChatUsers\ChatUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChatUsers extends ListRecords
{
    protected static string $resource = ChatUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

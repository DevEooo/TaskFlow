<?php

namespace App\Filament\Resources\Admin\Chats\Pages;

use App\Filament\Resources\Admin\Chats\ChatResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChat extends EditRecord
{
    protected static string $resource = ChatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}


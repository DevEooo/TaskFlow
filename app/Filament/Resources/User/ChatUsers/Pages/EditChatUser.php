<?php

namespace App\Filament\Resources\User\ChatUsers\Pages;

use App\Filament\Resources\User\ChatUsers\ChatUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditChatUser extends EditRecord
{
    protected static string $resource = ChatUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

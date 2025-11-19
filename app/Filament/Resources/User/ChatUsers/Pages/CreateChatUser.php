<?php

namespace App\Filament\Resources\User\ChatUsers\Pages;

use App\Filament\Resources\User\ChatUsers\ChatUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatUser extends CreateRecord
{
    protected static string $resource = ChatUserResource::class;
}

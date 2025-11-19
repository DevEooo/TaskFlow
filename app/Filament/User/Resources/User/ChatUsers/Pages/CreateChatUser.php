<?php

namespace App\Filament\User\Resources\User\ChatUsers\Pages;

use App\Filament\User\Resources\User\ChatUsers\ChatUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatUser extends CreateRecord
{
    protected static string $resource = ChatUserResource::class;
}

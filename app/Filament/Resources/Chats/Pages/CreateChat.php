<?php

namespace App\Filament\Resources\Chats\Pages;

use App\Filament\Resources\Chats\ChatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChat extends CreateRecord
{
    protected static string $resource = ChatResource::class;
}

<?php

namespace App\Filament\Resources\User\ChatUsers;

use App\Filament\Resources\User\ChatUsers\Pages\CreateChatUser;
use App\Filament\Resources\User\ChatUsers\Pages\EditChatUser;
use App\Filament\Resources\User\ChatUsers\Pages\ListChatUsers;
use App\Filament\Resources\User\ChatUsers\Schemas\ChatUserForm;
use App\Filament\Resources\User\ChatUsers\Tables\ChatUsersTable;
use App\Models\ChatUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ChatUserResource extends Resource
{
    protected static ?string $model = ChatUser::class;
    protected static ?string $slug = "chat-user";
    protected static ?string $label = "Chat";
    protected static ?string $navigationLabel = 'Chat';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    public static function form(Schema $schema): Schema
    {
        return ChatUserForm::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChatUsers::route('/'),
            'create' => CreateChatUser::route('/create'),
            'edit' => EditChatUser::route('/{record}/edit'),
        ];
    }
}

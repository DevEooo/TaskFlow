<?php

namespace App\Filament\Resources\Admin\Requests;

use App\Filament\Resources\Admin\Requests\Pages\CreateRequests;
use App\Filament\Resources\Admin\Requests\Pages\EditRequests;
use App\Filament\Resources\Admin\Requests\Pages\ListRequests;
use App\Filament\Resources\Admin\Requests\Schemas\RequestsForm;
use App\Filament\Resources\Admin\Requests\Tables\RequestsTable;
use App\Models\Requests;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class RequestsResource extends Resource
{
    protected static ?string $model = Requests::class;
    protected static ?string $navigationLabel = 'Permintaan';
    protected static ?string $slug = "permintaan";
    protected static ?string $label = "Data Permintaan";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return RequestsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequestsTable::configure($table);
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
            'index' => ListRequests::route('/'),
            'create' => CreateRequests::route('/create'),
            'edit' => EditRequests::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}


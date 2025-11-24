<?php

namespace App\Filament\Resources\Admin\Permintaan;

use App\Filament\Resources\Admin\Permintaan\Pages\CreatePermintaan;
use App\Filament\Resources\Admin\Permintaan\Pages\EditPermintaan;
use App\Filament\Resources\Admin\Permintaan\Pages\ListPermintaan;
use App\Filament\Resources\Admin\Permintaan\Schemas\PermintaanForm;
use App\Filament\Resources\Admin\Permintaan\Tables\PermintaanTable;
use App\Models\Requests;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class PermintaanResource extends Resource
{
    protected static ?string $model = Requests::class;
    protected static ?string $navigationLabel = 'Permintaan';
    protected static ?string $slug = "permintaan";
    protected static ?string $label = "Data Permintaan";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return PermintaanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PermintaanTable::configure($table);
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
            'index' => ListPermintaan::route('/'),
            'create' => CreatePermintaan::route('/create')
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

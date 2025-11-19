<?php

namespace App\Filament\Resources\Admin\Shifts;

use App\Filament\Resources\Admin\Shifts\Pages\CreateShifts;
use App\Filament\Resources\Admin\Shifts\Pages\EditShifts;
use App\Filament\Resources\Admin\Shifts\Pages\ListShifts;
use App\Filament\Resources\Admin\Shifts\Schemas\ShiftsForm;
use App\Filament\Resources\Admin\Shifts\Tables\ShiftsTable;
use App\Models\Shifts;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ShiftsResource extends Resource
{
    protected static ?string $model = Shifts::class;
    protected static ?string $navigationLabel = 'Shift Kerja';
    protected static ?string $slug = "shift-kerja";
    protected static ?string $label = "Data Shift Kerja";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMoon;

    public static function form(Schema $schema): Schema
    {
        return ShiftsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShiftsTable::configure($table);
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
            'index' => ListShifts::route('/'),
            'create' => CreateShifts::route('/create'),
            'edit' => EditShifts::route('/{record}/edit'),
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

<?php

namespace App\Filament\Resources\Admin\Absensis;

use App\Filament\Resources\Admin\Absensis\Pages\CreateAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\EditAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\ListAbsensis;
use App\Filament\Resources\Admin\Absensis\Pages\ViewAbsensi;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiForm;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiInfolist;
use App\Filament\Resources\Admin\Absensis\Tables\AbsensisTable;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Daftar Absensi";

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return AbsensiForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AbsensiInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AbsensisTable::configure($table);
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
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
            'view' => ViewAbsensi::route('/{record}'),
            'edit' => EditAbsensi::route('/{record}/edit'),
        ];
    }
}

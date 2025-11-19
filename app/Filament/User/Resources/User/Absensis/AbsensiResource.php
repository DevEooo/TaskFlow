<?php

namespace App\Filament\User\Resources\User\Absensis;

use App\Filament\User\Resources\User\Absensis\Pages\CreateAbsensi;
use App\Filament\User\Resources\User\Absensis\Pages\EditAbsensi;
use App\Filament\User\Resources\User\Absensis\Pages\ListAbsensis;
use App\Filament\User\Resources\User\Absensis\Schemas\AbsensiForm;
use App\Filament\User\Resources\User\Absensis\Tables\AbsensisTable;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Absensi Kehadiran";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    public static function form(Schema $schema): Schema
    {
        return AbsensiForm::configure($schema);
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
            'edit' => EditAbsensi::route('/{record}/edit'),
        ];
    }
}

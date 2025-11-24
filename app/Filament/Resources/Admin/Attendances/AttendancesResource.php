<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\Attendances\Pages\CreateAttendances;
use App\Filament\Resources\Admin\Attendances\Pages\EditAttendances;
use App\Filament\Resources\Admin\Attendances\Pages\ListAttendances;
use App\Filament\Resources\Admin\Attendances\Tables\AttendancesTable;
use App\Models\Attendances;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AttendancesResource extends Resource
{
    protected static ?string $model = Attendances::class;
    protected static ?string $slug = "attendances";
    protected static ?string $label = "Attendances";
    protected static ?string $navigationLabel = 'Attendances';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    public static function form(Schema $schema): Schema
    {
        // No AttendancesForm class available; return the provided schema unchanged.
        return $schema;
    }
    public static function table(Table $table): Table
    {
        // Default: return the provided table unchanged (create App\Filament\Resources\Admin\Attendances\Tables\AttendancesTable
        // with a static configure method if you need custom configuration)
        return $table;
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
            'index' => ListAttendances::route('/'),
            'create' => CreateAttendances::route('/create'),
            'edit' => EditAttendances::route('/{record}/edit'),
        ];
    }
}

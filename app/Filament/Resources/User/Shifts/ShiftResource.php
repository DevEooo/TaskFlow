<?php

namespace App\Filament\Resources\User\Shifts;

use App\Filament\Resources\User\Shifts\Pages\ListShifts;
use App\Filament\Resources\User\Shifts\Pages\ViewShift;
use App\Filament\Resources\User\Shifts\Tables\ShiftsTable;
use App\Models\Shift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ShiftResource extends Resource
{
    protected static ?string $model = Shift::class;
    protected static ?string $navigationLabel = 'Shift Kerja';
    protected static ?string $slug = "shift-kerja";
    protected static ?string $label = "Shift Kerja";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

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
            'view' => ViewShift::route('/{record}'),
        ];
    }
}

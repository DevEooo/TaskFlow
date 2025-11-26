<?php

namespace App\Filament\Resources\User\LogTugas;

use App\Filament\Resources\User\LogTugas\Pages\ListLogTugas;
use App\Filament\Resources\User\LogTugas\Pages\ViewLogTugas;
use App\Filament\Resources\User\LogTugas\Schemas\LogTugasForm;
use App\Filament\Resources\User\LogTugas\Tables\LogTugasTable;
use App\Models\LogTugas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LogTugasResource extends Resource
{
    protected static ?string $model = LogTugas::class;
    protected static ?string $navigationLabel = 'Log Tugas';
    protected static ?string $slug = "log-tugas";
    protected static ?string $label = "Log Tugas / Aktivitas";
    protected static string | UnitEnum | null $navigationGroup = 'History';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;
    public static function canView($record): bool
    {
        return $record->tugas && $record->tugas->user_id === auth()->id();
    }

    public static function table(Table $table): Table
    {
        return LogTugasTable::configure($table);
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
            'index' => ListLogTugas::route('/'),
            'view' => ViewLogTugas::route('/{record}'),
        ];
    }
}

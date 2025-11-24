<?php

namespace App\Filament\Resources\Admin\LogTugas;

use App\Filament\Resources\Admin\LogTugas\Pages\CreateLogTugas;
use App\Filament\Resources\Admin\LogTugas\Pages\EditLogTugas;
use App\Filament\Resources\Admin\LogTugas\Pages\ListLogTugas;
use App\Filament\Resources\Admin\LogTugas\Pages\ViewLogTugas;
use App\Filament\Resources\Admin\LogTugas\Schemas\LogTugasForm;
use App\Filament\Resources\Admin\LogTugas\Schemas\LogTugasInfolist;
use App\Filament\Resources\Admin\LogTugas\Tables\LogTugasTable;
use App\Models\LogTugas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class LogTugasResource extends Resource
{
    protected static ?string $model = Tugas::class;

     protected static ?string $navigationLabel = 'Log Tugas';
    protected static ?string $slug = "log-tugas";
    protected static ?string $label = "Data Log Tugas";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedNewspaper;

    public static function form(Schema $schema): Schema
    {
        return LogTugasForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LogTugasInfolist::configure($schema);
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
            'create' => CreateLogTugas::route('/create'),
            'view' => ViewLogTugas::route('/{record}'),
            'edit' => EditLogTugas::route('/{record}/edit'),
        ];
    }
}

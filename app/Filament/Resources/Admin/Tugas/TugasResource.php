<?php

namespace App\Filament\Resources\Admin\Tugas;

use App\Filament\Resources\Admin\Tugas\Pages\CreateTugas;
use App\Filament\Resources\Admin\Tugas\Pages\EditTugas;
use App\Filament\Resources\Admin\Tugas\Pages\ListTugas;
use App\Filament\Resources\Admin\Tugas\Schemas\TugasForm;
use App\Filament\Resources\Admin\Tugas\Tables\TugasTable;
use App\Models\Tugas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TugasResource extends Resource
{
    protected static ?string $model = Tugas::class;
    protected static ?string $navigationLabel = 'Tugas';
    protected static ?string $slug = "tugas";
    protected static ?string $label = "Data Daftar Tugas";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQueueList;

    public static function form(Schema $schema): Schema
    {
        return TugasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TugasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTugas::route('/'),
            'create' => CreateTugas::route('/create'),
            'edit' => EditTugas::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\User\ListTugas;

use App\Filament\Resources\User\ListTugas\Pages\CreateListTugas;
use App\Filament\Resources\User\ListTugas\Pages\EditListTugas;
use App\Filament\Resources\User\ListTugas\Pages\ListListTugas;
use App\Filament\Resources\User\ListTugas\Schemas\ListTugasForm;
use App\Filament\Resources\User\ListTugas\Tables\ListTugasTable;
use App\Models\Tugas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ListTugasResource extends Resource
{
    protected static ?string $model = Tugas::class;
    protected static ?string $slug = "list-tugas";
    protected static ?string $label = "Daftar List Tugas";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocument;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return ListTugasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ListTugasTable::configure($table);
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
            'index' => ListListTugas::route('/'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}

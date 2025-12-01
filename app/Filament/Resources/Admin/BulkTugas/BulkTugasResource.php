<?php

namespace App\Filament\Resources\Admin\BulkTugas;

use App\Filament\Resources\Admin\BulkTugas\Pages\CreateBulkTugas;
use App\Filament\Resources\Admin\BulkTugas\Pages\ListBulkTugas;
use App\Filament\Resources\Admin\BulkTugas\Schemas\BulkTugasForm;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use App\Models\Tugas;

class BulkTugasResource extends Resource
{
    protected static ?string $model = Tugas::class;

    protected static ?string $navigationLabel = 'Buat Tugas & Jadwal';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return BulkTugasForm::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBulkTugas::route('/'),
            'create' => CreateBulkTugas::route('/create'),
        ];
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return true;
    }
}

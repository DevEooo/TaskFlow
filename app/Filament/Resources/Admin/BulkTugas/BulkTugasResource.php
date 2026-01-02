<?php

namespace App\Filament\Resources\Admin\BulkTugas;

use App\Filament\Resources\Admin\BulkTugas\Pages\CreateBulkTugas;
use App\Filament\Resources\Admin\BulkTugas\Schemas\BulkTugasForm;
use App\Models\Tugas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BulkTugasResource extends Resource
{
    protected static ?string $model = Tugas::class;
    protected static ?string $navigationLabel = 'Buat Tugas & Jadwal';
    protected static ?string $slug = "bulk-tugas";
    protected static ?string $label = "Penugasan Tugas & Jadwal";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

    public static function form(Schema $schema): Schema
    {
        return BulkTugasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
            ->query(fn () => Tugas::whereRaw('1 = 0')); 
    }

    public static function getPages(): array
    {
        return [
            'index' => CreateBulkTugas::route('/'), 
            'create' => CreateBulkTugas::route('/create'),
        ];
    }
    public static function canAccess(): bool
    {
        return static::canCreate(); 
    }
    public static function canViewAny(): bool { return false; } 
    public static function canEdit(Model $record): bool { return false; }
    public static function canDelete(Model $record): bool { return false; }
}
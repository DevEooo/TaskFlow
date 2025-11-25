<?php

namespace App\Filament\Resources\User\Shifts;

use App\Models\JadwalShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;
use Filament\Tables\Columns;
use Filament\Schemas\Schema;

class ShiftResource extends Resource
{
    protected static ?string $model = JadwalShift::class;
    protected static ?string $navigationLabel = 'Shift Kerja Saya';
    protected static ?string $slug = "shift-kerja";
    protected static ?string $label = "Shift Kerja";
    protected static string|UnitEnum|null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    public static function canDelete(Model $record): bool
    {
        return false;
    }

    // User hanya perlu melihat, Form dikosongkan
    public static function form(Schema $schema): Schema
    {
        return $schema->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            // ⭐ BATASAN UTAMA: HANYA TAMPILKAN JADWAL MILIK USER YANG SEDANG LOGIN
            ->query(
                fn(Builder $query) => $query
                    ->where('user_id', auth()->id())
                    ->with('shift') // Eager load relasi shift
                    ->orderBy('date', 'asc') // Urutan ke atas untuk jadwal mendatang
            )

            ->columns([
                Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y (D)') // Tampilkan nama hari
                    ->sortable()
                    ->color(fn($state) => $state->isToday() ? 'primary' : 'gray'), // Highlight tanggal hari ini

                Columns\TextColumn::make('shift.name')
                    ->label('Shift Kerja')
                    ->badge()
                    ->sortable()
                    ->default('— Tidak Ada Shift —')
                    ->getStateUsing(fn ($record) => $record->shift?->name ?? 'N/A'),
                Columns\TextColumn::make('shift.start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->getStateUsing(fn($record) => $record->shift?->start_time ?? 'N/A'),

                Columns\TextColumn::make('shift.end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->getStateUsing(fn($record) => $record->shift?->end_time ?? 'N/A'),
            ])
            ->defaultSort('date', 'asc') // Urutkan dari tanggal terdekat/mendatang
            ->actions([
                // Tidak ada aksi edit/delete di sini
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShifts::route('/'),
        ];
    }
}

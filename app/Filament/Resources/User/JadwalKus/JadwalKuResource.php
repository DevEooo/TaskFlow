<?php

namespace App\Filament\Resources\User\JadwalKus;

use App\Filament\Resources\User\JadwalKus\Pages\ListJadwalKus;
use App\Filament\Resources\User\JadwalKus\Schemas\JadwalKuForm;
use App\Models\JadwalShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns;

class JadwalKuResource extends Resource
{
    protected static ?string $model = JadwalShift::class;
    protected static ?string $navigationLabel = 'Jadwal Shift-Ku';
    protected static ?string $slug = "jadwal-shift-ku";
    protected static ?string $label = "Jadwal Shift Saya";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function form(Schema $schema): Schema
    {
        return JadwalKuForm::configure($schema);
    }

    // --- PERBAIKAN DI SINI: Global Scope untuk Resource ini ---
    public static function getEloquentQuery(): Builder
    {
        // Kita panggil parent query dulu agar scope bawaan Filament (seperti SoftDelete) tetap jalan
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id()) // Filter hanya punya user yang login
            ->with('shift'); // Eager load relasi shift di sini agar lebih efisien
    }

    public static function canCreate(): bool { return false; }
    public static function canEdit(Model $record): bool { return false; }
    public static function canDelete(Model $record): bool { return false; }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y (D)') 
                    ->sortable()
                    ->color(fn($state) => $state->isToday() ? 'primary' : 'gray'), 

                Columns\TextColumn::make('shift.name')
                    ->label('Shift Kerja')
                    ->badge()
                    ->sortable()
                    ->placeholder('— Tidak Ada Shift —'), 

                Columns\TextColumn::make('shift.start_time')
                    ->label('Jam Mulai')
                    ->time('H:i')
                    ->placeholder('N/A'),

                Columns\TextColumn::make('shift.end_time')
                    ->label('Jam Selesai')
                    ->time('H:i')
                    ->placeholder('N/A'),
            ])
            ->defaultSort('date', 'asc') // Sorting tetap di sini
            ->actions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJadwalKus::route('/'),
        ];
    }
}
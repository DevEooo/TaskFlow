<?php

namespace App\Filament\Resources\User\JadwalKus;

use App\Filament\Resources\User\JadwalKus\Pages\ListJadwalKus;
use App\Models\JadwalShift;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns;
use Filament\Tables\Filters\SelectFilter;

class JadwalKuResource extends Resource
{
    protected static ?string $model = JadwalShift::class;
    protected static ?string $navigationLabel = 'Jadwal Shift-Ku';
    protected static ?string $slug = "jadwal-shift-ku";
    protected static ?string $label = "Jadwal Shift Saya";
    protected static string | UnitEnum | null $navigationGroup = 'Kelola';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClock;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
        ->whereNotNull('shift_id')
        ->where('user_id', auth()->id())
        ->with('shift');
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
            ->filters([
                SelectFilter::make('name')
                    ->options([
                        'Shift Pagi' => 'Shift Pagi',
                        'Shift Siang' => 'Shift Siang',
                        'Shift Malam' => 'Shift Malam',
                    ])
                    ->label('Filter Status Tugas')
            ])
            ->defaultSort('date', 'asc');
    }
    
    public static function getPages(): array
    {
        return [
            'index' => ListJadwalKus::route('/'),
        ];
    }
}
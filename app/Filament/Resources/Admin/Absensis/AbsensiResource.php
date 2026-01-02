<?php

namespace App\Filament\Resources\Admin\Absensis;

use App\Filament\Resources\Admin\Absensis\Pages\CreateAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\EditAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\ListAbsensis;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Actions\EditAction; 
use Filament\Actions\DeleteAction; 
use Filament\Tables\Filters\Filter;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiForm as AbsensiFormSchema;
use Filament\Tables\Columns\TextColumn;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $slug = "absensi-karyawan";
    protected static ?string $label = "Daftar Absensi";
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;
    public static function form(Schema $schema): Schema
    {
        return AbsensiFormSchema::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama OB')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('shift.name')
                    ->label('Shift')
                    ->badge()
                    ->color('gray')
                    ->placeholder('Tidak ada shift'),

                TextColumn::make('check_in')
                    ->label('Masuk')
                    ->dateTime('H:i')
                    ->sortable(),

                TextColumn::make('check_out')
                    ->label('Pulang')
                    ->dateTime('H:i')
                    ->placeholder('Belum Pulang'),
                
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'on_time' => 'success',
                        'late' => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('is_late')
                    ->label('Telat')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Telat' : 'Tepat Waktu')
                    ->color(fn (bool $state): string => $state ? 'danger' : 'success'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('today')
                    ->label('Hadir Hari Ini')
                    ->query(fn ($query) => $query->whereDate('created_at', today())),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(), 
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
            'edit' => EditAbsensi::route('/{record}/edit'),
        ];
    }
}


<?php

namespace App\Filament\Resources\Admin\Absensis;

use App\Filament\Resources\Admin\Absensis\Pages\CreateAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\EditAbsensi;
use App\Filament\Resources\Admin\Absensis\Pages\ListAbsensis;
use App\Filament\Resources\Admin\Absensis\Pages\ViewAbsensi;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiForm;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiInfolist;
use App\Filament\Resources\Admin\Absensis\Tables\AbsensisTable;
use App\Models\Absensi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

use Filament\Tables\Table;
use Filament\Actions\EditAction; 
use Filament\Tables\Actions\DeleteAction; 
use Filament\Tables\Columns; 
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms;
use Filament\Forms\Form;
use App\Filament\Resources\Admin\Absensis\Schemas\AbsensiForm as AbsensiFormSchema;
use Filament\Tables\Actions;
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
                // 1. Nama User
                TextColumn::make('user.name')
                    ->label('Nama OB')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // 2. Shift
                TextColumn::make('shift.name')
                    ->label('Shift')
                    ->badge()
                    ->color('gray')
                    ->placeholder('Tidak ada shift'),

                // 3. Waktu Check In
                TextColumn::make('check_in')
                    ->label('Masuk')
                    ->dateTime('H:i')
                    ->sortable(),

                // 4. Waktu Check Out
                TextColumn::make('check_out')
                    ->label('Pulang')
                    ->dateTime('H:i')
                    ->placeholder('Belum Pulang'),
                
                // 5. STATUS
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'on_time' => 'success',
                        'late' => 'danger',
                        default => 'warning',
                    }),

                // 6. INDICATOR TELAT
                TextColumn::make('is_late')
                    ->label('Telat')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Terlambat' : 'Tepat Waktu')
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
                // DeleteAction::make(), // Fitur untuk delete
            ]);
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
            'index' => ListAbsensis::route('/'),
            'create' => CreateAbsensi::route('/create'),
            'edit' => EditAbsensi::route('/{record}/edit'),
        ];
    }
}


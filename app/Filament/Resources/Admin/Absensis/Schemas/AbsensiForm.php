<?php

namespace App\Filament\Resources\Admin\Absensis\Schemas;

use App\Models\JadwalShift;
use App\Models\Shift;
use App\Models\User;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class AbsensiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Karyawan')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Karyawan')
                            ->options(User::all()->pluck('name', 'id'))
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                // Auto-fill shift based on today's schedule
                                $jadwalShift = JadwalShift::where('user_id', $state)
                                    ->where('date', today())
                                    ->with('shift')
                                    ->first();

                                if ($jadwalShift && $jadwalShift->shift) {
                                    $set('shift_id', $jadwalShift->shift_id);
                                }
                            }),

                        Forms\Components\Select::make('shift_id')
                            ->label('Shift')
                            ->options(Shift::all()->pluck('name', 'id'))
                            ->placeholder('Pilih shift atau akan diisi otomatis'),

                        Forms\Components\DateTimePicker::make('check_in')
                            ->label('Waktu Check In')
                            ->default(now())
                            ->required(),

                        Forms\Components\DateTimePicker::make('check_out')
                            ->label('Waktu Check Out')
                            ->placeholder('Opsional - kosongkan jika belum check out'),

                        Forms\Components\Select::make('status')
                            ->label('Status Kehadiran')
                            ->options([
                                'on_time' => 'Tepat Waktu',
                                'late' => 'Terlambat',
                                'done' => 'Selesai',
                            ])
                            ->default('on_time')
                            ->required(),

                        Forms\Components\Toggle::make('is_late')
                            ->label('Apakah Terlambat?')
                            ->default(false),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan')
                            ->placeholder('Catatan tambahan (opsional)'),

                        Forms\Components\TextInput::make('latitude')
                            ->label('Latitude')
                            ->numeric()
                            ->placeholder('Opsional'),

                        Forms\Components\TextInput::make('longitude')
                            ->label('Longitude')
                            ->numeric()
                            ->placeholder('Opsional'),
                    ])
                    ->columns(2),
            ]);
    }
}

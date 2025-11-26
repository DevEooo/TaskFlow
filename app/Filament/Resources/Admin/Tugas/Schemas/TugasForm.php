<?php

namespace App\Filament\Resources\Admin\Tugas\Schemas;

use App\Models\Shift;
use App\Models\User;
use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use App\Enums\PenempatanEnum;

class TugasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                // Kolom 1: Penugasan & Lokasi
                Section::make('Detail Penugasan')
                    ->schema([
                        // Memilih User yang akan ditugaskan
                        Components\Select::make('user_id')
                            ->label('Petugas (User)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        // Memilih Shift tugas
                        Components\Select::make('shift_id')
                            ->label('Shift Kerja')
                            ->options(Shift::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        // ⭐ BARU: Penempatan Tugas (Menggunakan Enum)
                        Components\Select::make('location')
                            ->label('Lokasi Penempatan')
                            ->options(
                                collect(PenempatanEnum::cases())
                                    ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                                    ->toArray()
                            )
                            ->required(),
                    ]),

                // Kolom 2: Judul dan Deskripsi Tugas
                Section::make('Judul dan Deskripsi')
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->maxLength(255)
                            ->required(),

                        // Deskripsi Tugas
                        Components\Textarea::make('task_description')
                            ->label('Deskripsi Lengkap Tugas')
                            ->rows(3)
                            ->columnSpan('full')
                            ->required(),

                        // Status Awal (Hidden)
                        Components\Hidden::make('status')
                            ->default('Pending'),
                    ]),
            ]);
    }
}
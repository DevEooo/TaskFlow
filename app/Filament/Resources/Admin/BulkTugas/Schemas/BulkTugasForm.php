<?php

namespace App\Filament\Resources\Admin\BulkTugas\Schemas;

use App\Enums\PenempatanEnum;
use App\Models\Shift;
use Filament\Forms\Components;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
 

class BulkTugasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3) // Menggunakan 3 kolom untuk tata letak yang lebih rapi
            ->schema([
                // Kolom 1: USER & SHIFT
                Section::make('Penugasan Karyawan')
                    ->columnSpan(1)
                    ->schema([
                        Components\Select::make('user_id')
                            ->label('Petugas (User)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),

                        Components\Select::make('shift_id')
                            ->label('Shift Kerja')
                            ->options(Shift::pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),

                        Components\Select::make('location')
                            ->label('Lokasi Penempatan')
                            ->options(PenempatanEnum::class)
                            ->required(),
                    ]),

                // Kolom 2: JUDUL & DESKRIPSI
                Section::make('Detail Tugas Harian')
                    ->columnSpan(2)
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->maxLength(255)
                            ->required(),

                        Components\Textarea::make('task_description')
                            ->label('Deskripsi Lengkap Tugas')
                            ->rows(4)
                            ->columnSpan('full')
                            ->required(),
                    ]),

                // Kolom 3: RENTANG TANGGAL (PENTING UNTUK BULK)
                Section::make('Periode Penugasan')
                    ->columnSpan('full')
                    ->schema([
                        Components\DatePicker::make('start_date')
                            ->label('Tanggal Mulai Penugasan')
                            ->required()
                            ->columnSpan(1),

                        Components\DatePicker::make('end_date')
                            ->label('Tanggal Akhir Penugasan')
                            ->after('start_date') // Validasi: Akhir harus setelah Mulai
                            ->required()
                            ->columnSpan(1),
                    ]),

                // Status Awal
                Components\Hidden::make('status')
                    ->default('Pending'),
            ]);
    }
}
<?php

namespace App\Filament\Resources\User\TugasKus\Schemas;

use Filament\Forms\Components;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TugasKuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->schema([
                // 1. DETAIL TUGAS (Read Only)
                Section::make('Detail Tugas yang Ditugaskan')
                    ->description('Tugas yang Anda terima ini harus diselesaikan dengan bukti foto yang valid.')
                    ->schema([
                        // Tampilkan Judul dan Deskripsi sebagai konteks read-only
                        Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->readOnly(),

                        Components\Textarea::make('task_description')
                            ->label('Deskripsi Lengkap Tugas')
                            ->rows(3)
                            ->readOnly(),
                    ]),

                // 2. BUKTI KERJA (Uploads)
                Section::make('Bukti Kerja dan Penyelesaian')
                    ->schema([
                        // Bukti Foto Sebelum (Opsional)
                        Components\FileUpload::make('photo_before_path')
                            ->label('Foto Sebelum Pengerjaan (Opsional)')
                            ->disk('public') // Ganti dengan disk S3/lain jika tidak menggunakan local storage
                            ->directory('tugas-before') // Folder penyimpanan
                            ->image()
                            ->maxSize(2048) // Maksimal 2MB
                            ->columnSpan('full'),

                        // Bukti Foto Sesudah (Mandatory)
                        Components\FileUpload::make('photo_after_path')
                            ->label('Foto Sesudah Pengerjaan (Wajib)')
                            ->disk('public')
                            ->directory('tugas-after')
                            ->image()
                            ->required()
                            ->maxSize(2048) // Maksimal 2MB
                            ->columnSpan('full'),
                            
                        // Status (Hidden, akan diisi di Page Edit)
                        Components\Hidden::make('status'),
                    ]),
            ]);
    }
}

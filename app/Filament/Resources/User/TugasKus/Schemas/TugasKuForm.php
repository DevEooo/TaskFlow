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
                Section::make('Detail Tugas yang Ditugaskan')
                    ->description('Tugas yang Anda terima ini harus diselesaikan dengan bukti foto yang valid.')
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->readOnly(),

                        Components\Textarea::make('task_description')
                            ->label('Deskripsi Lengkap Tugas')
                            ->rows(3)
                            ->readOnly(),
                    ]),

                Section::make('Bukti Kerja dan Penyelesaian')
                    ->schema([
                        Components\FileUpload::make('photo_before_path')
                            ->label('Foto Sebelum Pengerjaan (Opsional)')
                            ->disk('public')
                            ->directory('tugas-before')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                            ->maxSize(2048)
                            ->columnSpan('full'),

                        Components\FileUpload::make('photo_after_path')
                            ->label('Foto Sesudah Pengerjaan (Wajib)')
                            ->disk('public')
                            ->directory('tugas-after')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'])
                            ->required()
                            ->maxSize(2048)
                            ->columnSpan('full'),
                            
                        Components\Hidden::make('status'),
                    ]),
            ]);
    }
}

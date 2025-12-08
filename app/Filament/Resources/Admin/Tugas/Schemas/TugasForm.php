<?php

namespace App\Filament\Resources\Admin\Tugas\Schemas;

use App\Models\Shift;
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
                Section::make('Detail Penugasan')
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
                            ->options(
                                collect(PenempatanEnum::cases())
                                    ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
                                    ->toArray()
                            )
                            ->required(),
                    ]),

                Section::make('Judul dan Deskripsi')
                    ->schema([
                        Components\TextInput::make('title')
                            ->label('Judul Tugas')
                            ->maxLength(255)
                            ->required(),

                        Components\Textarea::make('task_description')
                            ->label('Deskripsi Lengkap Tugas')
                            ->rows(3)
                            ->columnSpan('full')
                            ->required(),

                        Components\Hidden::make('status')
                            ->default('Pending'),
                    ]),
            ]);
    }
}
<?php

namespace App\Filament\Resources\Admin\Tugas\Tables;

use Filament\Tables\Columns;
use Filament\Tables\Table;

class TugasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('created_at')
                    ->label('Tanggal Tugas')
                    ->date('d M Y')
                    ->sortable()
                    ->alignment('center'),

                Columns\TextColumn::make('user.name') 
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),

                // ⭐ BARU: Menampilkan Judul Tugas
                Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('shift.name') 
                    ->label('Shift')
                    ->sortable()
                    ->placeholder('-'),

                // ⭐ BARU: Menampilkan Nama Pemberi Tugas (Dari hook Model)
                Columns\TextColumn::make('assigner.name') 
                    ->label('Pemberi Tugas')
                    ->sortable()
                    ->placeholder('System'),

                Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'Pending' => 'warning',
                        'In Progress' => 'info',
                        'Complete' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
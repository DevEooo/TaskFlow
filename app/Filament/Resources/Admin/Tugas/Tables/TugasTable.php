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

                Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->sortable(),

                Columns\TextColumn::make('shift.name') 
                    ->label('Shift')
                    ->sortable()
                    ->placeholder('-'),

                Columns\TextColumn::make('assigner.name') 
                    ->label('Pemberi Tugas')
                    ->sortable()
                    ->placeholder('System'),

                Columns\ImageColumn::make('photo_before_path')
                    ->label('Bukti Sebelum')
                    ->size(40)
                    ->placeholder('Tidak ada')
                    ->url(fn ($record) => $record->photo_before_path ? asset('storage/' . ltrim($record->photo_before_path, '/')) : null)
                    ->openUrlInNewTab(),

                Columns\ImageColumn::make('photo_after_path')
                    ->label('Bukti Sesudah')
                    ->size(40)
                    ->placeholder('Tidak ada')
                    ->url(fn ($record) => asset('storage/' . ltrim($record->photo_after_path, '/'))) // Menjadikan gambar bisa diklik/diunduh
                    ->openUrlInNewTab(),

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
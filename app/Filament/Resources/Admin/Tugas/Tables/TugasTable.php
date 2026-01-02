<?php

namespace App\Filament\Resources\Admin\Tugas\Tables;

use Filament\Tables\Columns;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

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

                Columns\TextColumn::make('deadline_at')
                    ->label('Batas Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color(
                        fn($record) =>
                        ($record->status !== 'Complete' && now() > $record->deadline_at) ? 'danger' :
                        ($record->status !== 'Complete' && now()->diffInHours($record->deadline_at, false) < 2 ? 'warning' : 'gray')
                    )
                    ->description(
                        fn($record) =>
                        ($record->status !== 'Complete' && now() > $record->deadline_at) ? 'Terlewat!' : ''
                    )
                    ->placeholder('Belum ditentukan'),

                Columns\ImageColumn::make('photo_before_path')
                    ->label('Bukti Sebelum')
                    ->size(50)
                    ->placeholder('Tidak ada')
                    ->getStateUsing(fn($record) => $record->photo_before_path ? asset('storage/' . ltrim($record->photo_before_path, '/')) : null)
                    ->url(fn($record) => $record->photo_before_path ? asset('storage/' . ltrim($record->photo_before_path, '/')) : null)
                    ->openUrlInNewTab(),

                Columns\ImageColumn::make('photo_after_path')
                    ->label('Bukti Sesudah')
                    ->size(50)
                    ->placeholder('Tidak ada')
                    ->getStateUsing(fn($record) => $record->photo_after_path ? asset('storage/' . ltrim($record->photo_after_path, '/')) : null)
                    ->url(fn($record) => asset('storage/' . ltrim($record->photo_after_path, '/'))) // Menjadikan gambar bisa diklik/diunduh
                    ->openUrlInNewTab(),

                Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'Pending' => 'warning',
                        'In Progress' => 'info',
                        'Complete' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Pending' => 'Pending',
                        'In Progress' => 'In Progress',
                        'Complete' => 'Complete',
                    ])
                    ->label('Filter Status Tugas')
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
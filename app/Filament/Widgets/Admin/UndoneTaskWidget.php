<?php

namespace App\Filament\Widgets\Admin;

use App\Models\Tugas;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;


class UndoneTaskWidget extends BaseWidget
{
    protected static ?string $heading = 'Peringatan Tugas Terabaikan';
    protected static ?int $sort = 40;
    protected ?string $pollingInterval = '5s';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tugas::query()
                    ->where('status', 'Pending')
                    ->where('created_at', '<=', now()->subHour())
                    ->orderBy('created_at', 'asc')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Petugas')
                    ->icon('heroicon-m-user')
                    ->description(fn (Tugas $record): string => "Lokasi: {$record->location}"),

                TextColumn::make('title')
                    ->label('Nama Tugas')
                    ->limit(30),

                TextColumn::make('created_at')
                    ->label('Waktu Pemberian')
                    ->dateTime('H:i')
                    ->color('danger')
                    ->description(fn (Tugas $record): string => $record->created_at->diffForHumans()),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color('danger'),
            ])
            ->actions([
                Action::make('view')
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Tugas $record): string => "/admin/tugas/{$record->id}"),
            ])
            ->paginated([5, 10, 25, 50])
            ->defaultPaginationPageOption(5)
            ->emptyStateHeading('Semua tugas terpantau lancar')
            ->emptyStateDescription('Tidak ada tugas yang terabaikan saat ini.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
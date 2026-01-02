<?php

namespace App\Filament\Widgets\User;

use App\Models\Tugas;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Filament\Support\Enums\FontWeight;
use Filament\Actions\Action;

class ListTugasWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Tugas Aktif & Tertunda';
    protected static ?int $sort = 50;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $pollingInterval = '5s';
    protected static bool $isLazy = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tugas::query()
                    ->where('user_id', Auth::id())
                    ->whereIn('status', ['Pending', 'On Progress'])
                    ->orderBy('created_at', 'desc')  
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Tugas')
                    ->weight(FontWeight::Bold)
                    ->searchable()
                    ->description(fn (Tugas $record): string => Str::limit($record->task_description, 60)),

                Tables\Columns\TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge()
                    ->color('gray')
                    ->icon('heroicon-m-map-pin'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'On Progress' => 'info',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'Pending' => 'heroicon-m-clock',
                        'On Progress' => 'heroicon-m-arrow-path',
                        default => 'heroicon-m-question-mark-circle',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pemberian')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->color('gray')
                    ->size('sm'),
            ])
            ->actions([
                Action::make('view')
                    ->label('Lihat Detail')
                    ->icon('heroicon-m-eye')
                    ->color('primary')
                    ->url(fn (Tugas $record): string => "/user/tugas-kus/{$record->id}"),
            ])
            ->emptyStateHeading('Semua Tugas Selesai')
            ->emptyStateDescription('Hebat! Anda telah menyelesaikan semua tanggung jawab untuk saat ini.')
            ->emptyStateIcon('heroicon-o-check-badge')
            ->paginated([5, 10]);
    }
}
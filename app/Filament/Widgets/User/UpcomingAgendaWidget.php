<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UpcomingAgendaWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 1;
    protected static ?int $sort = 40;
    protected static ?string $pollingInterval = '5s';
    protected static bool $isLazy = false;
    public function table(Table $table): Table
    {
        return $table
            ->query(
                JadwalShift::query()
                    ->where('user_id', Auth::id())
                    ->where('date', '>=', now()->toDateString())
                    ->with('shift')
                    ->orderBy('date', 'asc')
                    ->limit(5)
            )
            ->heading('Agenda Mendatang')
            ->paginated(false)  
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Waktu')
                    ->weight('bold')
                    ->color('primary')
                    ->formatStateUsing(function ($state) {
                        $date = Carbon::parse($state);
                        $diff = now()->startOfDay()->diffInDays($date->startOfDay(), false);
                        
                        $label = match(true) {
                            $diff === 0 => 'Hari Ini',
                            $diff === 1 => 'Besok',
                            default => $diff . ' Hari Lagi',
                        };

                        return $label;
                    })
                    ->description(fn ($record) => Carbon::parse($record->date)->translatedFormat('l, d M')),

                Tables\Columns\TextColumn::make('shift.name')
                    ->label('Shift')
                    ->iconColor(fn ($record) => match ($record->shift?->name) {
                        'Pagi', 'Shift Pagi' => 'warning',
                        'Siang', 'Shift Siang' => 'info',
                        'Malam', 'Shift Malam' => 'purple',
                        default => 'success',
                    })
                    ->description(fn ($record) => 
                        $record->shift 
                        ? Carbon::parse($record->shift->start_time)->format('H:i') . ' - ' . Carbon::parse($record->shift->end_time)->format('H:i')
                        : 'Shift tidak ditemukan'
                    ),
            ])
            ->emptyStateHeading('Tidak ada agenda mendatang')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
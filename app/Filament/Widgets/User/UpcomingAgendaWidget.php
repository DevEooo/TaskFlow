<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Widgets\Widget;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UpcomingAgendaWidget extends Widget implements HasInfolists
{
    use InteractsWithInfolists;

    /**
     * Menggunakan view bawaan filament-widgets untuk Infolist.
     * Pastikan plugin 'filament/infolists' sudah terinstall.
     */
    protected static string $view = 'filament-widgets::infolist-widget';

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 2;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'upcoming_shifts' => JadwalShift::query()
                    ->where('user_id', Auth::id())
                    ->where('date', '>=', now()->toDateString())
                    ->with('shift')
                    ->orderBy('date', 'asc')
                    ->limit(5)
                    ->get()
            ])
            ->schema([
                Section::make('Agenda Mendatang')
                    ->description('Jadwal shift Anda untuk beberapa hari ke depan.')
                    ->icon('heroicon-m-calendar-days')
                    ->schema([
                        RepeatableEntry::make('upcoming_shifts')
                            ->label('')
                            ->schema([
                                TextEntry::make('countdown')
                                    ->label('')
                                    ->weight('bold')
                                    ->getStateUsing(function ($record) {
                                        $date = Carbon::parse($record->date);
                                        $diff = now()->startOfDay()->diffInDays($date->startOfDay(), false);
                                        
                                        return match(true) {
                                            $diff === 0 => 'Hari Ini',
                                            $diff === 1 => 'Besok',
                                            default => $diff . ' Hari Lagi',
                                        };
                                    })
                                    ->color('primary'),

                                TextEntry::make('shift.name')
                                    ->label('')
                                    ->icon('heroicon-s-circle')
                                    ->iconColor(fn ($record) => match ($record->shift?->name) {
                                        'Pagi', 'Shift Pagi' => 'warning',
                                        'Siang', 'Shift Siang' => 'info',
                                        'Malam', 'Shift Malam' => 'purple',
                                        default => 'success',
                                    })
                                    ->description(fn ($record) => 
                                        $record->shift ? 
                                        Carbon::parse($record->date)->translatedFormat('l, d M') . ' • ' .
                                        Carbon::parse($record->shift->start_time)->format('H:i') . ' - ' .
                                        Carbon::parse($record->shift->end_time)->format('H:i')
                                        : 'Shift tidak ditemukan'
                                    ),
                            ])
                            ->columns(1)
                            ->grid(1)
                    ])
            ]);
    }
}
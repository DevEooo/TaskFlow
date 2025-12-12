<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShiftWidget extends BaseWidget
{
    protected static ?int $sort = 30;
    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $userId = Auth::id();
        $today = Carbon::today();
        $now = Carbon::now();

        $schedule = JadwalShift::where('user_id', $userId)
            ->whereDate('date', $today)
            ->with('shift')
            ->first();

        $statusLabel = 'Libur / Off';
        $color = 'gray';
        $shiftName = 'Tidak Ada Shift';
        $startTime = '-';
        $endTime = '-';
        $icon = 'heroicon-m-face-smile';

        if ($schedule && $schedule->shift) {
            $shiftName = $schedule->shift->name;
            $startTime = Carbon::parse($schedule->shift->start_time)->format('H:i');
            $endTime = Carbon::parse($schedule->shift->end_time)->format('H:i');

            $start = Carbon::parse($today->toDateString() . ' ' . $schedule->shift->start_time);
            $end = Carbon::parse($today->toDateString() . ' ' . $schedule->shift->end_time);

            if ($end->lessThan($start)) {
                $end->addDay();
            }

            if ($now->between($start, $end)) {
                $statusLabel = 'Sedang Berlangsung';
                $color = 'success'; // Hijau
                $icon = 'heroicon-m-clock';
            } elseif ($now->lessThan($start)) {
                $statusLabel = 'Akan Datang';
                $color = 'info'; // Biru
                $icon = 'heroicon-m-arrow-up-right';
            } else {
                $statusLabel = 'Shift Selesai';
                $color = 'warning'; // Kuning/Oranye
                $icon = 'heroicon-m-check-badge';

                $tomorrow = $today->copy()->addDay();
                $nextSchedule = JadwalShift::where('user_id', $userId)->whereDate('date', $tomorrow)->exists();
                if (!$nextSchedule) {
                    $statusLabel = 'Shift Selesai - Menunggu Jadwal';
                    $color = 'gray';
                    $icon = 'heroicon-m-clock';
                }
            }
        }

        if (!$schedule || !$schedule->shift) {
            return [
                Stat::make('Jadwal Hari Ini', 'Tidak Ada Jadwal / Libur')
                    ->description('Tidak ada jadwal hari ini, silahkan beristirahat.')
                    ->descriptionIcon('heroicon-m-face-smile')
                    ->color('gray'),
            ];
        }

        return [
            Stat::make('Shift Hari Ini', $shiftName)
                ->description("Status: " . $statusLabel)
                ->descriptionIcon($icon)
                ->color($color),

            Stat::make('Jam Kerja', "$startTime - $endTime")
                ->description('Tanggal: ' . $today->translatedFormat('d F Y'))
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('gray'),  
        ];
    }
}
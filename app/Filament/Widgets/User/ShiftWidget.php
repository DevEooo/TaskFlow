<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Filament\Widgets\Widget; // Ganti ke Livewire Component Base
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShiftWidget extends Widget // Tetap gunakan Widget class bawaan Filament
{
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 1;

    protected string $view = 'filament.widgets.user.shift-widget';

    protected function getViewData(): array
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $schedule = JadwalShift::where('user_id', $userId)
            ->whereDate('date', $today)
            ->with('shift')
            ->first();

        $status = 'off';  
        $statusLabel = 'Libur / Off';
        $color = 'gray';

        if ($schedule && $schedule->shift) {
            $now = Carbon::now();
            
            // Menggabungkan tanggal hari ini dengan waktu shift (PENTING untuk perbandingan)
            $start = Carbon::parse($today->toDateString() . ' ' . $schedule->shift->start_time);
            $end = Carbon::parse($today->toDateString() . ' ' . $schedule->shift->end_time);

            // Jika Shift melintasi hari (misal 22:00 - 06:00), maka end harus di hari berikutnya
            if ($end->lessThan($start)) {
                $end->addDay();
            }

            if ($now->between($start, $end)) {
                $status = 'ongoing';
                $statusLabel = 'Sedang Berlangsung';
                $color = 'success';
            } elseif ($now->lessThan($start)) {
                $status = 'upcoming';
                $statusLabel = 'Akan Datang';
                $color = 'info';
            } else {
                $status = 'finished';
                $statusLabel = 'Shift Selesai';
                $color = 'warning';
            }
            
            // Pastikan kita mengirim waktu yang benar untuk ditampilkan di Blade
            $schedule->start_time_formatted =  Carbon::parse($schedule->shift->start_time)->format('H:i');
            $schedule->end_time_formatted =  Carbon::parse($schedule->shift->end_time)->format('H:i');
        }

        return [
            'schedule' => $schedule,
            'status' => $status,
            'statusLabel' => $statusLabel,
            'statusColor' => $color,
            'todayFormatted' => Carbon::now()->translatedFormat('l, d F Y'),
        ];
    }
}
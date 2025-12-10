<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ShiftWidget extends Widget
{
    protected static string $view = 'filament.widgets.user.shift-widget';
    protected static ?int $sort = 1; 
    protected int | string | array $columnSpan = 1; 

    protected function getViewData(): array
    {
        $userId = Auth::id();
        $today = Carbon::today();

        $schedule = JadwalShift::where('user_id', $userId)
            ->where('date', $today->toDateString())
            ->with('shift')  
            ->first();
        $status = 'off';  
        $statusLabel = 'Libur / Off';
        $color = 'gray';

        if ($schedule && $schedule->shift) {
            $now = Carbon::now();
            $start = Carbon::parse($schedule->shift->start_time);
            $end = Carbon::parse($schedule->shift->end_time);

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
        }

        return [
            'schedule' => $schedule,
            'status' => $status,
            'statusLabel' => $statusLabel,
            'statusColor' => $color,
        ];
    }
}
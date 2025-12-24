<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 30;
    public Model | string | int | null $record = null;
    protected int | string | array $columnSpan = 1;
    protected static ?string $pollingInterval = '7s';
    public function fetchEvents(array $fetchInfo): array
    {
        return JadwalShift::query()
            ->where('user_id', auth()->id())
            ->where('date', '>=', $fetchInfo['start'])
            ->where('date', '<=', $fetchInfo['end'])
            ->with('shift')
            ->get()
            ->map(function (JadwalShift $jadwal) {
                
                $color = match ($jadwal->shift->name) {
                    'Pagi', 'Shift Pagi' => '#fbbf24', // Amber/Kuning
                    'Siang', 'Shift Siang' => '#3b82f6', // Biru
                    'Malam', 'Shift Malam' => '#8b5cf6', // Ungu
                    default => '#10b981', // Emerald/Hijau
                };

                $dateFormatted = Carbon::parse($jadwal->date)->format('Y-m-d');
                $start = Carbon::parse($dateFormatted . ' ' . $jadwal->shift->start_time);
                $end = Carbon::parse($dateFormatted . ' ' . $jadwal->shift->end_time);
                
                if ($end->lessThan($start)) {
                    $end->addDay();
                }

                return [
                    'id'    => $jadwal->id,
                    'title' => '', 
                    'start' => $start->toIso8601String(),
                    'end'   => $end->toIso8601String(),
                    'color' => $color,
                    'display' => 'list-item', 
                ];
            })
            ->all();
    }

    public function config(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth',
            ],
            'initialView' => 'dayGridMonth',
            'height' => 500,
            'eventDisplay' => 'block',
        ];
    }
    
    protected function headerActions(): array
    {
        return [];
    }
    
    protected function modalActions(): array
    {
        return [];
    }
}
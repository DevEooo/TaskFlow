<?php

namespace App\Filament\Widgets\User;

use App\Models\JadwalShift;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CalendarWidget extends FullCalendarWidget
{
    protected static ?int $sort = 40;
    protected int | string | array $columnSpan = 1;
    protected static bool $isLazy = false;
    protected ?string $pollingInterval = '5s';
    public Model | string | int | null $record = null;
    public function fetchEvents(array $fetchInfo): array
    {
        return JadwalShift::query()
            ->where('user_id', auth()->id())
            ->where('date', '>=', $fetchInfo['start'])
            ->where('date', '<=', $fetchInfo['end'])
            ->with('shift')
            ->get()
            ->map(function (JadwalShift $jadwal) {
                
                $color = match ($jadwal->shift?->name) {
                    'Pagi', 'Shift Pagi' => '#fbbf24', // Amber
                    'Siang', 'Shift Siang' => '#3b82f6', // Biru
                    'Malam', 'Shift Malam' => '#8b5cf6', // Ungu
                    default => '#10b981', // Hijau
                };

                return [
                    'id'    => $jadwal->id,
                    'title' => $jadwal->shift?->name ?? 'Shift',
                    'start' => Carbon::parse($jadwal->date)->format('Y-m-d'),
                    'color' => $color,
                    'display' => 'block',
                    'allDay' => true,
                ];
            })
            ->all();
    }

    public function config(): array
    {
        return [
            'headerToolbar' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'dayGridMonth',
            ]
        ];
    }

    public function onEventClick(array $event): void {}

    protected function headerActions(): array
    {
        return [];
    }
}
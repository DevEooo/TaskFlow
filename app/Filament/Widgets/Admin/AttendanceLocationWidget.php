<?php

namespace App\Filament\Widgets\Admin;

use App\Models\Absensi;
use App\Enums\PenempatanEnum;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class AttendanceLocationWidget extends ChartWidget
{
    protected ?string $heading = 'Jumlah Kehadiran Berdasarkan Lokasi';
    protected static ?int $sort = 20;
    protected ?string $height = '600px';
    protected static bool $isLazy = false;
    protected bool $isFullWidth = true;
    protected ?string $pollingInterval = '5s';
    protected function getData(): array
    {
        $startOfToday = Carbon::today()->startOfDay();
        $endOfToday = Carbon::today()->endOfDay();

        $locations = collect(PenempatanEnum::cases())->map(fn ($case) => $case->value);

        $data = [];
        foreach ($locations as $location) {
            $count = Absensi::query()
                ->whereHas('user', function ($query) use ($location) {
                    $query->where('penempatan', $location);
                })
                ->whereBetween('created_at', [$startOfToday, $endOfToday])
                ->distinct('user_id')
                ->count('user_id');

            $data[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Personel',
                    'data' => $data,
                    'barThickness' => 40,
                    'maxBarThickness' => 50,
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.8)', // Blue
                        'rgba(16, 185, 129, 0.8)', // Emerald
                        'rgba(245, 158, 11, 0.8)', // Amber
                        'rgba(239, 68, 68, 0.8)',  // Red
                        'rgba(139, 92, 246, 0.8)', // Violet
                    ],
                    'borderColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                        '#8b5cf6',
                    ],
                    'borderWidth' => 1,
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $locations->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'height' => 600,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'min' => 0,
                    'suggestedMax' => 40,  
                    'ticks' => [
                        'stepSize' => 5
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false, 
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                    'padding' => 20,
                ],
            ],
        ];
    }
}
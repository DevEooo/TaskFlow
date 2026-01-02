<?php

namespace App\Filament\Widgets\Admin;

use App\Models\Absensi;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SummarizeChartWidget extends ChartWidget
{
    protected ?string $heading = 'Analisis Trend & Performa Kehadiran';
    protected static ?int $sort = 20;
    protected ?string $maxHeight = '400px';
    protected static bool $isLazy = false;
    protected ?string $pollingInterval = '5s';
    protected function getData(): array
    {
        $avg30Days = Absensi::whereBetween('check_in', [now()->subDays(30), now()])
            ->select(DB::raw('COUNT(DISTINCT user_id) as daily_total'))
            ->groupBy(DB::raw('DATE(check_in)'))
            ->get()
            ->avg('daily_total') ?? 0;

        $dailySeries = collect(range(6, 0))->map(function ($days) {
            $date = Carbon::today()->subDays($days);
            
            $count = Absensi::whereDate('check_in', $date)
                ->distinct('user_id')
                ->count('user_id');

            return [
                'day' => $date->translatedFormat('D'),  
                'value' => $count,
            ];
        });

        $avg7Days = $dailySeries->avg('value') ?? 0;

        return [
            'datasets' => [
                [
                    'label' => 'Kehadiran Riil',
                    'data' => $dailySeries->pluck('value')->toArray(),
                    'borderColor' => '#10b981', // Emerald 500
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                    'tension' => 0.4, 
                    'pointRadius' => 5,
                    'pointHitRadius' => 10,
                    'borderWidth' => 3,
                ],
                [
                    'label' => 'Rata-rata 7 Hari',
                    'data' => array_fill(0, 7, round($avg7Days, 1)),
                    'borderColor' => '#f59e0b', // Amber 500
                    'borderDash' => [5, 5], 
                    'pointRadius' => 0,
                    'fill' => false,
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Rata-rata 30 Hari',
                    'data' => array_fill(0, 7, round($avg30Days, 1)),
                    'borderColor' => '#3b82f6', // Blue 500
                    'borderDash' => [10, 5],  
                    'pointRadius' => 0,
                    'fill' => false,
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $dailySeries->pluck('day')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,  
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                        'precision' => 0,
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Jumlah Personel',
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,  
                    ],
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }
}
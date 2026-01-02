<?php

namespace App\Filament\Widgets\Admin;

use App\Models\Tugas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TugasStatsOverview extends BaseWidget
{
    protected static ?int $sort = 10;
    protected ?string $pollingInterval = '5s';
    protected function getStats(): array
    {
        $totalTugas = Tugas::count();
        $tugasComplete = Tugas::where('status', 'Complete')->count();
        $tugasPending = Tugas::where('status', 'Pending')->count();
        
        $completionRate = $totalTugas > 0 
            ? round(($tugasComplete / $totalTugas) * 100) 
            : 0;

        return [
        
            Stat::make('Tugas Selesai', $tugasComplete . ' Tugas')
                ->description($completionRate . '% Tingkat Penyelesaian')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Menunggu Petugas', $tugasPending . ' Tugas')
                ->description('Baru ditugaskan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
                
            Stat::make('Total Tugas Dibuat', $totalTugas . ' Tugas')
                ->description('Total tugas dalam sistem')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),
        ];
    }
}
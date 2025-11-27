<?php

namespace App\Filament\Widgets;

use App\Models\Tugas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TugasStatsOverview extends BaseWidget
{
    protected static ?int $sort = 20;

    protected function getStats(): array
    {
        // 1. Ambil data semua tugas
        $totalTugas = Tugas::count();
        $tugasComplete = Tugas::where('status', 'Complete')->count();
        $tugasPending = Tugas::where('status', 'Pending')->count();
        $tugasInProgress = Tugas::where('status', 'In Progress')->count();
        
        // Hitung persentase penyelesaian
        $completionRate = $totalTugas > 0 
            ? round(($tugasComplete / $totalTugas) * 100) 
            : 0;

        return [
        
            Stat::make('Tugas Selesai', $tugasComplete . ' Tugas')
                ->description($completionRate . '% Tingkat Penyelesaian')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('On Going', $tugasInProgress . ' Tugas')
                ->description('Diambil, namun belum selesai')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('info'),

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
    
    // Opsional: Refresh otomatis setiap 5 detik
    // protected static ?string $pollingInterval = '7s';
}
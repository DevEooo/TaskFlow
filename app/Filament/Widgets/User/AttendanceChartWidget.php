<?php

namespace App\Filament\Widgets\User;

use App\Models\Absensi;
use App\Models\JadwalShift;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceChartWidget extends ChartWidget
{
    protected ?string $heading = 'Status Kehadiran Bulan Ini';
    protected static ?int $sort = 30; 
    protected int | string | array $columnSpan = 'full';
    protected ?string $maxHeight = '250px';
    protected function getData(): array
    {   
        $userId = Auth::id();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        
        $onTime = Absensi::where('user_id', $userId)
            ->whereBetween('check_in', [$startOfMonth, $endOfMonth])
            ->where(function($query) {
                $query->where('notes', 'not like', '%Terlambat%')
                      ->orWhereNull('notes');
            })
            ->count();

        $late = Absensi::where('user_id', $userId)
            ->whereBetween('check_in', [$startOfMonth, $endOfMonth])
            ->where('notes', 'like', '%Terlambat%')
            ->count();

        // 2. Hitung Sakit / Izin
        $excused = Absensi::where('user_id', $userId)
            ->whereBetween('check_in', [$startOfMonth, $endOfMonth])
            ->where(fn($q) => $q->where('notes', 'like', '%Sakit%')->orWhere('notes', 'like', '%Izin%'))
            ->count();

        // 3. Hitung Alpa (Tidak Absen)
        $totalWorkDaysSoFar = JadwalShift::where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth->toDateString(), now()->toDateString()])
            ->count();
        
        $totalAbsenceRecorded = Absensi::where('user_id', $userId)
            ->whereBetween('check_in', [$startOfMonth, now()])
            ->count();

        $alpa = max(0, $totalWorkDaysSoFar - $totalAbsenceRecorded);

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Hari',
                    'data' => [$onTime, $late, $excused, $alpa],
                    'backgroundColor' => [
                        '#10b981', // Emerald 500 (Masuk Tepat Waktu)
                        '#fbbf24', // Amber 400 (Terlambat)
                        '#3b82f6', // Blue 500 (Sakit/Izin)
                        '#ef4444', // Red 500 (Alpa/Tidak Absen)
                    ],
                    'hoverOffset' => 4
                ],
            ],
            'labels' => [
                'Tepat Waktu', 
                'Terlambat', 
                'Sakit / Izin', 
                'Tidak Absen'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getDescription(): ?string
    {
        return 'Ringkasan kehadiran Anda periode bulan ini.';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true, // Mengubah kotak legenda menjadi titik agar lebih hemat tempat
                        'boxWidth' => 8,
                    ],
                ],
            ],
            'cutout' => '65%', // Sedikit dikurangi agar donat tidak terlalu tipis saat diperkecil
            'maintainAspectRatio' => false,
        ];
    }
}
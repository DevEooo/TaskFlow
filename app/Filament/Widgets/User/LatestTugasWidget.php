<?php

namespace App\Filament\Widgets\User;

use App\Models\Tugas;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class LatestTugasWidget extends BaseWidget
{
    protected static ?int $sort = 20;
    protected int | string | array $columnSpan = 'full';
    protected ?string $pollingInterval = '5s';
    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        $userId = Auth::id();
        $task = Tugas::where('user_id', $userId)
            ->whereIn('status', ['Pending', 'On Progress'])
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$task) {
            return [
                Stat::make('Status Tugas', 'Semua Selesai')
                    ->description('Kerja bagus! Tidak ada tanggungan saat ini.')
                    ->descriptionIcon('heroicon-m-face-smile')
                    ->color('success')
                    ->chart([7, 2, 10, 3, 15, 4, 17]),
            ];
        }

        $color = match($task->status) {
            'Pending' => 'warning',
            'On Progress' => 'info',
            default => 'gray',
        };

        $editUrl = \App\Filament\Resources\User\TugasKus\TugasKuResource::getUrl('edit', ['record' => $task->id], panel: 'user');

        return [
            Stat::make('Tugas Terbaru', $task->title)
                ->description('Prioritas utama Anda')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('primary'),

            Stat::make('Tanggal Dibuat', $task->created_at->translatedFormat('d F Y'))
                ->description($task->created_at->diffForHumans())
                ->descriptionIcon('heroicon-m-calendar')
                ->color('gray'),

            Stat::make('Status', $task->status)
                ->description('Klik disini untuk selesaikan') 
                ->descriptionIcon('heroicon-m-arrow-right')
                ->color($color)
                ->url($editUrl) 
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:scale-105 transition-transform', 
                ]),
        ];
    }
}
<?php

namespace App\Filament\Widgets\User;

use Filament\Widgets\Widget;
use App\Models\Tugas;
use Illuminate\Support\Facades\Auth;

class LatestTugasWidget extends Widget
{
    protected string $view = 'filament.widgets.user.latest-tugas-widget';
    protected static ?string $pollingInterval = '60s'; 
    protected int | string | array $columnSpan = 'full';
    protected function getLatestTaskData(): ?Tugas
    {
        $userId = Auth::id();
        
        return Tugas::where('user_id', $userId)
            ->whereIn('status', ['Pending', 'On Progress'])
            ->orderBy('created_at', 'desc')
            ->first();
    }
    
    // Kirim data ke view
    protected function getViewData(): array
    {
        $task = $this->getLatestTaskData();
        
        if (!$task) {
            return [
                'task' => null,
                'statusColor' => 'gray',
                'statusLabel' => 'Tidak Ada Tugas Aktif',
            ];
        }

        $statusColor = match($task->status) {
            'Pending' => 'warning',
            'On Progress' => 'info',
            default => 'gray',
        };

        return [
            'task' => $task,
            'statusColor' => $statusColor,
            'statusLabel' => $task->status,
        ];
    }
}
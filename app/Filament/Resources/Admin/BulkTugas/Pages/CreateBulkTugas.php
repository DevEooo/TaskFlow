<?php

namespace App\Filament\Resources\Admin\BulkTugas\Pages;

use App\Filament\Resources\Admin\BulkTugasResource;
use App\Models\Tugas;
use App\Models\JadwalShift;  
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateBulkTugas extends CreateRecord
{
    protected static string $resource = BulkTugasResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $assignedById = Auth::id();
        $tasksCreatedCount = 0;
        $scheduleCreatedCount = 0;
        
        $userId = $data['user_id'];
        $shiftId = $data['shift_id'] ?? null;
        
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            Tugas::create([
                'user_id' => $userId,
                'shift_id' => $shiftId,
                'location' => $data['location'],
                'title' => $data['title'],
                'task_description' => $data['task_description'],
                'status' => 'Pending',
                'assigned_by_id' => $assignedById,
                
                'created_at' => $date, 
            ]);
            $tasksCreatedCount++;

            if ($shiftId) {
                JadwalShift::create([
                    'user_id' => $userId,
                    'shift_id' => $shiftId,
                    'date' => $date->toDateString(),
                    'assigned_by_id' => $assignedById,
                ]);
                $scheduleCreatedCount++;
            }
            
            // ⭐ LOGIC NOTIFIKASI TUGAS BARU (dapat dipicu di sini)
            // Asumsi: Kita kirim notifikasi bahwa ada tugas baru untuk tanggal ini.
        }

        Notification::make()
            ->title("Penugasan Bulk Berhasil!")
            ->body("{$tasksCreatedCount} tugas harian dan {$scheduleCreatedCount} jadwal shift telah dibuat untuk periode {$startDate->format('d/m/Y')} hingga {$endDate->format('d/m/Y')}.")
            ->success()
            ->send();

        return new Tugas(); 
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }
    
    
    protected function getFormActions(): array 
    {
        $actions = parent::getFormActions();
        if (isset($actions['create'])) {
            $actions['create']->label('Buat Tugas & Jadwal Bulk');
        }
        return $actions;
    }
}
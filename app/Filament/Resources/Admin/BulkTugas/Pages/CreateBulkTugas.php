<?php

namespace App\Filament\Resources\Admin\BulkTugas\Pages;

use App\Filament\Resources\Admin\BulkTugas\BulkTugasResource;
use App\Models\Tugas;
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

        // Loop melalui setiap tanggal dalam rentang
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $task = Tugas::create([
                'user_id' => $data['user_id'],
                'shift_id' => $data['shift_id'] ?? null,
                'location' => $data['location'],
                'title' => $data['title'],
                'task_description' => $data['task_description'],
                'status' => 'Pending',
                'assigned_by_id' => $assignedById,
                'created_at' => $date, 
                'updated_at' => $date,
            ]);
            $tasksCreatedCount++;
            
            // ⭐ LOGIC NOTIFIKASI TUGAS BARU (Lihat Bagian 4)
            // SendNotification::dispatch($task); 
        }

        Notification::make()
            ->title("Penugasan Berhasil!")
            ->body("{$tasksCreatedCount} tugas harian telah dibuat untuk periode {$startDate->format('d/m/Y')} hingga {$endDate->format('d/m/Y')}.")
            ->success()
            ->send();

        return new Tugas(); 
    }

    protected function getRedirectUrl(): string
    {
        // Redirect kembali ke halaman Create setelah sukses
        return $this->getResource()::getUrl('create');
    }
    
    protected function getFormActions(): array 
    {
        return array_slice(parent::getFormActions(), 0, 1); // Hanya tampilkan Create
    }
}
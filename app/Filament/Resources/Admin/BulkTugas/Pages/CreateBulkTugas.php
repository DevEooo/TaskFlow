<?php

namespace App\Filament\Resources\Admin\BulkTugas\Pages;

use App\Filament\Resources\Admin\BulkTugas\BulkTugasResource;
use App\Models\Tugas;   
use App\Models\JadwalShift;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Filament\Resources\User\TugasKus\TugasKuResource;

class CreateBulkTugas extends CreateRecord
{
    protected static string $resource = BulkTugasResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        \Log::info("handleRecordCreation called with data: " . json_encode($data));

        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $assignedById = Auth::id();
        $tasksCreatedCount = 0;
        $scheduleCreatedCount = 0;

        $userId = $data['user_id'];
        $shiftId = $data['shift_id'] ?? null;
        $recipient = User::find($userId);

        \Log::info("Recipient found: " . ($recipient ? "Yes, ID: {$recipient->id}, Role: {$recipient->role}" : "No"));

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            \Log::info("Creating task for date: " . $date->format('Y-m-d'));

            $deadlineTime = $data['deadline_time'];
            $deadlineAt = $date->copy()->setTimeFromTimeString($deadlineTime);

            Tugas::create([
                'user_id' => $userId,
                'shift_id' => $shiftId,
                'location' => $data['location'],
                'title' => $data['title'],
                'task_description' => $data['task_description'],
                'status' => 'Pending',
                'assigned_by_id' => $assignedById,
                'created_at' => $date,
                'deadline_at' => $deadlineAt,
                'is_late' => false,
            ]);
            $tasksCreatedCount++;
            \Log::info("Task created, count: {$tasksCreatedCount}");

            if ($shiftId) {
                JadwalShift::create([
                    'user_id' => $userId,
                    'shift_id' => $shiftId,
                    'date' => $date->toDateString(),
                    'assigned_by_id' => $assignedById,
                ]);
                $scheduleCreatedCount++;
                \Log::info("Schedule created, count: {$scheduleCreatedCount}");
            }
        }

        \Log::info("Loop finished. Tasks: {$tasksCreatedCount}, Schedules: {$scheduleCreatedCount}");

        if ($recipient && $recipient->role === 'user') {
            \Log::info("Attempting to send notification to user ID: {$recipient->id}, Name: {$recipient->name}");

            try {
                \DB::table('notifications')->insert([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'type' => 'Filament\Notifications\DatabaseNotification',
                    'notifiable_type' => 'App\Models\User',
                    'notifiable_id' => $recipient->id,
                    'data' => json_encode([
                        'title' => 'Tugas Baru Ditugaskan',
                        'body' => "{$tasksCreatedCount} tugas '{$data['title']}' telah ditugaskan untuk periode {$startDate->format('d M Y')} - {$endDate->format('d M Y')}",
                        'icon' => 'heroicon-o-clipboard-document-list',
                        'iconColor' => 'primary',
                        'actions' => [
                            [
                                'name' => 'Lihat Tugas',
                                'url' => TugasKuResource::getUrl('index', panel: 'user'),
                                'button' => true,
                                'markAsRead' => true,
                            ]
                        ],
                        'format' => 'filament',
                    ]),
                    'read_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                \Log::info("Notification inserted directly to database for user ID: {$recipient->id}");

                $notificationCount = $recipient->notifications()->count();
                \Log::info("User now has {$notificationCount} notifications in database");

                Notification::make()
                    ->title('Notifikasi Tugas Dikirim')
                    ->body("Notifikasi tugas telah dikirim ke {$recipient->name} ({$recipient->email}). Total notifications: {$notificationCount}")
                    ->info()
                    ->send();
            } catch (\Exception $e) {
                \Log::error("Failed to send notification to user ID: {$recipient->id}. Error: " . $e->getMessage());

                Notification::make()
                    ->title('Error: Gagal Mengirim Notifikasi')
                    ->body("Gagal mengirim notifikasi ke {$recipient->name}. Error: " . $e->getMessage())
                    ->danger()
                    ->send();
            }
        } elseif (!$recipient) {
            \Log::warning("Recipient not found for user_id: {$userId}");

            Notification::make()
                ->title('Error: User Tidak Ditemukan')
                ->body('Tidak dapat menemukan user untuk mengirim notifikasi.')
                ->danger()
                ->send();
        } elseif ($recipient->role !== 'user') {
            \Log::warning("Recipient role is not 'user'. User ID: {$recipient->id}, Role: {$recipient->role}");

            Notification::make()
                ->title('Error: Role User Tidak Valid')
                ->body("User {$recipient->name} tidak memiliki role 'user'.")
                ->danger()
                ->send();
        }

        Notification::make()
            ->title("Penugasan Bulk Berhasil!")
            ->body("{$tasksCreatedCount} tugas harian dan {$scheduleCreatedCount} jadwal shift telah dibuat...")
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
<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\UserAbsensiResource;
use App\Models\Absensi;
use App\Models\JadwalShift;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = UserAbsensiResource::class;

    protected ?string $heading = 'Form Absensi Harian';

    protected static bool $canCreateAnother = false;

    protected function handleRecordCreation(array $data): Model
    {
        $user = auth()->user();
        $statusInput = $data['status'];

        if ($statusInput === 'check_in') {
            $existingCheckIn = Absensi::where('user_id', $user->id)
                ->whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->exists();

            if ($existingCheckIn) {
                Notification::make()
                    ->danger()
                    ->title('Gagal Check In')
                    ->body('Anda sudah melakukan Check In hari ini! Tidak dapat Check In dua kali.')
                    ->send();

                $this->halt();
            }

            $checkInTime = now();
            $data['check_in'] = $checkInTime;
            $data['user_id'] = $user->id;

            $jadwalShift = JadwalShift::where('user_id', $user->id)
                ->where('date', today())
                ->with('shift')
                ->first();

            if ($jadwalShift && $jadwalShift->shift) {
                $data['shift_id'] = $jadwalShift->shift_id;
                $shiftStartTime = today()->setTimeFromTimeString($jadwalShift->shift->start_time);
                if ($checkInTime->greaterThan($shiftStartTime)) {
                    $data['status'] = 'late';
                    $data['is_late'] = true;
                } else {
                    $data['status'] = 'on_time';
                    $data['is_late'] = false;
                }
            } else {
                $data['status'] = 'on_time';
                $data['is_late'] = false;
            }

            return static::getModel()::create($data);
        }

        if ($statusInput === 'check_out') {
            $absensi = Absensi::where('user_id', $user->id)
                ->whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereNull('check_out')
                ->first();

            if (!$absensi) {

                Notification::make()
                    ->danger()
                    ->title('Gagal Check Out')
                    ->body('Belum ada Check In hari ini atau Anda sudah Check Out.')
                    ->send();

                $this->halt();
            }

            $jadwalShift = JadwalShift::where('user_id', $user->id)
                ->where('date', today())
                ->with('shift')
                ->first();

            $currentTime = now();
            if ($jadwalShift && $jadwalShift->shift) {
                $shiftEndTime = today()->setTimeFromTimeString($jadwalShift->shift->end_time);
                if ($currentTime->lessThan($shiftEndTime)) {

                    Notification::make()
                        ->warning()
                        ->title('Peringatan Check Out Dini')
                        ->body("Anda check-out sebelum waktu shift berakhir ({$jadwalShift->shift->end_time}). Pastikan Anda telah menyelesaikan tugas dengan baik.")
                        ->send();
                }
            }


            $absensi->update([
                'check_out' => $currentTime,
                'status' => 'done',
                'report_notes' => $data['notes'] ?? $absensi->report_notes,
            ]);

            return $absensi;
        }

        return parent::handleRecordCreation($data);
    }
    protected function getFormActions(): array
    {
        $status = UserAbsensiResource::getTodayAbsensiStatus()['status'];

        if ($status === 'done') {
            return []; // Hide action buttons when attendance is done
        }

        $actionLabel = match ($status) {
            'pending_out' => 'Check Out Sekarang',
            'pending_in' => 'Check In Sekarang',
            default => 'Kirim Data',
        };

        return [
            $this->getCreateFormAction()->label($actionLabel),
            $this->getCancelFormAction(),
        ];
    }
    protected function getCreatedNotification(): ?Notification
    {
        $status = $this->data['status'] ?? 'unknown';
        $user = auth()->user();
        $time = now()->format('H:i');

        // Tentukan konten pesan
        if ($status === 'check_in') {
            $title = 'Check In Berhasil';
            $body = "Anda masuk pada pukul {$time}. Selamat bekerja!";
            $icon = 'heroicon-o-arrow-right-end-on-rectangle';
            $color = 'success';
        } else {
            $title = 'Check Out Berhasil';
            $body = "Anda pulang pada pukul {$time}. Terima kasih!";
            $icon = 'heroicon-o-arrow-left-start-on-rectangle';
            $color = 'info';
        }

        // 1. Buat Objek Notifikasi
        $notification = Notification::make()
            ->title($title)
            ->body($body)
            ->icon($icon)
            ->color($color);

        // 2. Kirim Notifikasi Database ke DIRI SENDIRI (Agar muncul di lonceng User)
        $notification->sendToDatabase($user);

        // 3. (Opsional) Kirim Notifikasi ke SEMUA ADMIN jika Telat
        // Anda bisa menambahkan logika if($isLate) di sini untuk notifikasi ke Admin

        // 4. Return notifikasi untuk Toast (muncul sesaat di pojok kanan atas)
        return $notification;
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('create');
    }


}

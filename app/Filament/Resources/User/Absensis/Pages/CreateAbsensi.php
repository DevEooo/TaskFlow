<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\UserAbsensiResource;
use App\Models\Absensi;
use App\Models\JadwalShift;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = UserAbsensiResource::class;

    // Kita modifikasi judul halamannya
    protected ?string $heading = 'Form Absensi Harian';

    // Matikan redirect default agar kita bisa atur sendiri notifikasinya
    protected static bool $canCreateAnother = false;

    /**
     * Fungsi utama untuk menangani logika penyimpanan data
     */
    protected function handleRecordCreation(array $data): Model
    {
        $user = auth()->user();
        $statusInput = $data['status']; // 'check_in' atau 'check_out' dari form

        if ($statusInput === 'check_in') {
            // Cek apakah user sudah check-in hari ini?
            $existingCheckIn = Absensi::where('user_id', $user->id)
                ->whereDay('created_at', now()->day) // Cek hanya hari
                ->whereMonth('created_at', now()->month) // Cek hanya bulan
                ->whereYear('created_at', now()->year) // Cek hanya tahun
                ->exists();

            if ($existingCheckIn) {
                // Lempar error jika sudah check-in
                Notification::make()
                    ->danger()
                    ->title('Gagal Check In')
                    ->body('Anda sudah melakukan Check In hari ini! Tidak dapat Check In dua kali.')
                    ->send();
                
                $this->halt(); // Hentikan proses
            }

            // Jika belum, simpan data baru
            $checkInTime = now(); // Set waktu otomatis server
            $data['check_in'] = $checkInTime;
            $data['user_id'] = $user->id;

            // Set shift_id berdasarkan jadwal shift hari ini
            $jadwalShift = JadwalShift::where('user_id', $user->id)
                ->where('date', today())
                ->with('shift')
                ->first();

            // Tentukan status berdasarkan waktu check-in vs waktu mulai shift
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
                // Jika tidak ada jadwal shift, gunakan default on_time
                $data['status'] = 'on_time';
                $data['is_late'] = false;
            }

            return static::getModel()::create($data);
        }

        // ---------------------------------------------------------
        // SKENARIO 2: CHECK OUT
        // ---------------------------------------------------------
        if ($statusInput === 'check_out') {
            // Cari data check-in hari ini milik user yang belum check-out (check_out masih null)
            $absensi = Absensi::where('user_id', $user->id)
                ->whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->whereNull('check_out') // Cari yang belum check-out
                ->first();

            if (! $absensi) {
                // Error jika mau pulang tapi belum pernah masuk atau sudah check out
                Notification::make()
                    ->danger()
                    ->title('Gagal Check Out')
                    ->body('Belum ada Check In hari ini atau Anda sudah Check Out.')
                    ->send();

                $this->halt();
            }

            // Cek jadwal shift untuk validasi waktu check-out
            $jadwalShift = JadwalShift::where('user_id', $user->id)
                ->where('date', today())
                ->with('shift')
                ->first();

            $currentTime = now();
            if ($jadwalShift && $jadwalShift->shift) {
                $shiftEndTime = today()->setTimeFromTimeString($jadwalShift->shift->end_time);
                if ($currentTime->lessThan($shiftEndTime)) {
                    // Notifikasi peringatan jika check-out sebelum waktu shift berakhir
                    Notification::make()
                        ->warning()
                        ->title('Peringatan Check Out Dini')
                        ->body("Anda check-out sebelum waktu shift berakhir ({$jadwalShift->shift->end_time}). Pastikan Anda telah menyelesaikan tugas dengan baik.")
                        ->send();
                }
            }

            // Update data yang sudah ada
            $absensi->update([
                'check_out' => $currentTime, // Set waktu pulang
                'status' => 'done',   // Tandai selesai
                'report_notes' => $data['notes'] ?? $absensi->report_notes, // Catatan bisa diperbarui
            ]);

            return $absensi;
        }

        return parent::handleRecordCreation($data);
    }

    /**
     * Notifikasi Sukses
     */
    protected function getCreatedNotification(): ?Notification
    {
        // Notifikasi lebih spesifik berdasarkan aksi
        $status = $this->data['status'] ?? 'unknown';

        $title = ($status === 'check_in') ? 'Check In Berhasil!' : 'Check Out Berhasil!';
        $body = ($status === 'check_in') ? 'Selamat bekerja. Data kehadiran Anda telah tercatat.' : 'Terima kasih atas kerja kerasnya. Data kepulangan telah tercatat.';

        return Notification::make()
            ->success()
            ->title($title)
            ->body($body);
    }
    
    protected function getRedirectUrl(): string
    {
        // Redirect kembali ke halaman form setelah submit
        return $this->getResource()::getUrl('create');
    }
}

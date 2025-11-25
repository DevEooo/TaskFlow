<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\AbsensiResource;
use App\Models\Absensi;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateAbsensi extends CreateRecord
{
    protected static string $resource = AbsensiResource::class;

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
            $data['check_in'] = now(); // Set waktu otomatis server
            $data['user_id'] = $user->id;
            $data['status'] = 'in_progress'; // Set status sedang bekerja
            
            return static::getModel()::create($data);
        }

        // ---------------------------------------------------------
        // SKENARIO 2: CHECK OUT
        // ---------------------------------------------------------
        if ($statusInput === 'check_out') {
            // Cari data check-in hari ini milik user yang statusnya masih 'in_progress'
            $absensi = Absensi::where('user_id', $user->id)
                ->whereDay('created_at', now()->day)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->where('status', 'in_progress') // Hanya ambil yang sedang in_progress
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

            // Update data yang sudah ada
            $absensi->update([
                'check_out' => now(), // Set waktu pulang
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

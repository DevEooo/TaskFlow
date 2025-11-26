<?php

namespace App\Filament\Resources\User\TugasKus\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use App\Filament\Resources\User\TugasKus\TugasKuResource;

class EditTugasKu extends EditRecord
{
    protected static string $resource = TugasKuResource::class;
    
    // Ganti Title Page agar lebih jelas
    public function getTitle(): string
    {
        return 'Selesaikan Tugas: ' . $this->getRecord()->title;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Cek jika foto after sudah di-upload (mandatori)
        if ($data['photo_after_path']) {
            $data['status'] = 'Selesai';
            $data['completed_at'] = Carbon::now();
        } 
        // Jika tidak ada foto after, status tetap, dan Filament akan memicu error required field
        
        return $data;
    }

    // ⭐ Custom Notification setelah tugas selesai
    protected function getSavedNotificationTitle(): ?string
    {
        return 'Tugas berhasil diselesaikan! Bukti kerja telah dikirim.';
    }
    
    public function mount(int | string $record): void
    {
        parent::mount($record);
        
        // Memastikan user hanya bisa mengakses tugasnya sendiri
        abort_unless($this->getRecord()->user_id === auth()->id(), 403);
        
        // Jika tugas sudah Selesai/Complete, redirect kembali ke list index
        if ($this->getRecord()->status === 'Complete') {
             $this->redirect($this->getResource()::getUrl('index'));
        }
    }
}

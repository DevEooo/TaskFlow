<?php

namespace App\Filament\Resources\User\TugasKus\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use App\Filament\Resources\User\TugasKus\TugasKuResource;
use Filament\Notifications\Notification;

class EditTugasKu extends EditRecord
{
    protected static string $resource = TugasKuResource::class;
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
        if ($data['photo_after_path']) {
            $data['status'] = 'Complete';
            $waktuSelesai = Carbon::now();
            $data['completed_at'] = $waktuSelesai;

            $deadline = $this->getRecord()->deadline_at;

            if ($deadline && $waktuSelesai->greaterThan($deadline)) {
                $data['is_late'] = true;  
                
                Notification::make()
                    ->warning()
                    ->title('Tugas Diselesaikan Terlambat')
                    ->body("Tugas selesai melewati batas waktu ({$deadline->format('H:i')}).")
                    ->send();
            } else {
                $data['is_late'] = false;
            }
        } 
        
        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Tugas berhasil diselesaikan! Bukti kerja telah dikirim.';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    public function mount(int | string $record): void
    {
        parent::mount($record); 
        abort_unless($this->getRecord()->user_id === auth()->id(), 403);
        
        if ($this->getRecord()->status === 'Complete') {
             $this->redirect($this->getResource()::getUrl('index'));
        }
    }
}

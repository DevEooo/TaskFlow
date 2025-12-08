<?php

namespace App\Filament\Resources\User\TugasKus\Pages;

use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Carbon;
use App\Filament\Resources\User\TugasKus\TugasKuResource;

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
            $data['completed_at'] = Carbon::now();
        }

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Tugas berhasil diselesaikan! Bukti kerja telah dikirim.';
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

<?php

namespace App\Filament\Resources\User\TugasKus\Pages;

use App\Filament\Resources\User\TugasKus\TugasKuResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTugasKu extends ViewRecord
{
    protected static string $resource = TugasKuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Ambil / Selesaikan Tugas'),
        ];
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        abort_unless($this->getRecord()->user_id === auth()->id(), 403);
    }
}

<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\AbsensiResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAbsensi extends EditRecord
{
    protected static string $resource = AbsensiResource::class;

    public static function canEdit(Model $record): bool  // Statement untuk disable edit
    {
        return false;
    }

    // Kita kosongkan saja, karena user tidak seharusnya bisa mengakses edit.
}
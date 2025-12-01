<?php

namespace App\Filament\Resources\User\Absensis\Pages;

use App\Filament\Resources\User\Absensis\UserAbsensiResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditAbsensi extends EditRecord
{
    protected static string $resource = UserAbsensiResource::class;

    public static function canEdit(Model $record): bool  // Statement untuk disable edit
    {
        return false;
    }

    // Kita kosongkan saja, karena user tidak seharusnya bisa mengakses edit.
}
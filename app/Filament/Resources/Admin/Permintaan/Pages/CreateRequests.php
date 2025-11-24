<?php

namespace App\Filament\Resources\Admin\Requests\Pages;

use App\Filament\Resources\Admin\Requests\RequestsResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRequests extends CreateRecord
{
    protected static string $resource = RequestsResource::class;
}


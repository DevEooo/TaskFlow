<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PenempatanEnum;

class LogTugas extends Model
{

    protected $fillable = [
        'location',
        'photo_before_path',
        'photo_after_path',
    ];

    protected $casts = [
        'location' => PenempatanEnum::class,
    ];
}

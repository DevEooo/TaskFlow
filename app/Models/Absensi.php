<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    use HasFactory;

    // PENTING: Paksa model ini menggunakan tabel 'attendances'
    protected $table = 'absensi'; 

    protected $fillable = [
        'user_id',
        'shift_id',
        'check_in',
        'check_out',
        'photo_path',
        'notes',
        'status',
        'is_late',
        'latitude',
        'longitude',
    ];

    // Relasi ke User agar User Panel tahu siapa yang login
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift_id',
        'title',
        'task_description',
        'location',
        'status',
        'photo_before_path',
        'photo_after_path',
        'completed_at',
        'assigned_by_id',
    ];

    protected static function booted()
    {
        static::creating(function ($tugas) {
            // Mengisi assigned_by_id dengan ID Admin yang sedang login
            $tugas->assigned_by_id = Auth::id();
        });
    }

    // Relasi ke User yang Ditugaskan
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Shift
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    // Relasi ke User yang Memberi Tugas (Admin/Supervisor)
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }
}
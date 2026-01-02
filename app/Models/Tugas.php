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
        'deadline_at',
        'is_late',
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_late' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($tugas) {
            $tugas->assigned_by_id = Auth::id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }
}
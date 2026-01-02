<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shift')->nullOnDelete();

            $table->dateTime('check_in')->nullable()->comment('Waktu masuk kerja');
            $table->dateTime('check_out')->nullable()->comment('Waktu pulang kerja');

            // Data Pendukung
            $table->string('photo_path')->nullable()->comment('Path foto bukti selfie');
            $table->text('notes')->nullable()->comment('Catatan harian dari OB');
            
            // Status & Kalkulasi
            $table->string('status')->default('pending')->comment('Status kehadiran: on_time, late, dll');
            $table->boolean('is_late')->default(false)->comment('Penanda apakah telat atau tidak');
            
            // Lokasi (Opsional: Untuk pengembangan masa depan)
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
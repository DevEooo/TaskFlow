<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift')->unique()->comment('Nama Shift (Pagi, Siang, Malam)');
            $table->time('start_time')->comment('Jam Mulai Shift');
            $table->time('end_time')->comment('Jam Selesai Shift');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
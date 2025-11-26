<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();

            // Kunci Asing (Foreign Keys)
            $table->foreignId('user_id')
                ->constrained('users') // Mengacu ke tabel users
                ->cascadeOnDelete();

            $table->foreignId('shift_id')
                ->nullable() // Tugas bisa jadi tidak terikat shift
                ->constrained('shifts') // Mengacu ke tabel shifts (Model Shift)
                ->cascadeOnDelete();

            $table->string('title'); // Judul Tugas
            $table->string('location');
            // Detail Tugas
            $table->text('task_description');

            // Status Tugas
            $table->enum('status', ['Pending', 'In Progress', 'Complete', 'Rejected'])
                ->default('Pending');

            // Log Foto/File (akan digunakan di Panel User saat user menyelesaikan tugas)
            $table->string('photo_before_path')->nullable();
            $table->string('photo_after_path')->nullable();
            $table->timestamp('completed_at')->nullable(); // Waktu penyelesaian

            // Siapa yang memberikan tugas (opsional)
            $table->foreignId('assigned_by_id')
                ->nullable()
                ->constrained('users');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
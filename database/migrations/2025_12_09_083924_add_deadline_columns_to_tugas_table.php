<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dateTime('deadline_at')->nullable()->after('task_description');
            $table->boolean('is_late')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('tugas', function (Blueprint $table) {
            $table->dropColumn(['deadline_at', 'is_late']);
        });
    }
};

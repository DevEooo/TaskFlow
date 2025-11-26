<? 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('log_tugas', function (Blueprint $table) {
            $table->id();
            
            // Kunci Asing ke Tugas mana log ini terkait
            $table->foreignId('tugas_id')
                  ->constrained('tugas') 
                  ->cascadeOnDelete();
                  
            // Kunci Asing ke User yang melakukan aksi (dalam hal ini, user yang ditugaskan)
            $table->foreignId('user_id') 
                  ->constrained('users')
                  ->cascadeOnDelete();
            
            // Tipe Aksi (e.g., Assigned, In Progress, Completed)
            $table->string('action'); 
            
            // Pesan Detail Log
            $table->text('details')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('log_tugas');
    }
};
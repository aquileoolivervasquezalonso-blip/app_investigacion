
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investigadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nombre_completo');
            $table->string('grado_academico')->nullable();
            $table->string('especialidad')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->text('cv')->nullable();
            $table->string('foto')->nullable();
            $table->foreignId('cuerpo_academico_id')->nullable()->constrained('cuerpos_academicos')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investigadores');
    }
};

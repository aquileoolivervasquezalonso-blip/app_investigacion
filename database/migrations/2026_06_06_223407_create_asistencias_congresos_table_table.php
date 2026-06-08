
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias_congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_congreso');
            $table->string('sede')->nullable();
            $table->date('fecha')->nullable();
            $table->enum('tipo_participacion', ['Asistente', 'Ponente', 'Cartel'])->default('Asistente');
            $table->string('titulo_ponencia')->nullable();
            $table->string('constancia')->nullable();
            $table->foreignId('investigador_id')->nullable()->constrained('investigadores')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias_congresos');
    }
};

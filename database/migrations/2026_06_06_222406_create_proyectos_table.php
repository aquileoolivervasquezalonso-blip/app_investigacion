
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['En curso', 'Concluido'])->default('En curso');
            $table->string('financiamiento')->nullable();
            $table->decimal('monto', 12, 2)->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->text('resultados')->nullable();
            $table->foreignId('investigador_id')->nullable()->constrained('investigadores')->nullOnDelete();
            $table->foreignId('linea_investigacion_id')->nullable()->constrained('lineas_investigacion')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};

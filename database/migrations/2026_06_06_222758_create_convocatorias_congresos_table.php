
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('convocatorias_congresos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('sede')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_evento')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->enum('estado', ['Abierta', 'Cerrada'])->default('Abierta');
            $table->string('enlace')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('convocatorias_congresos');
    }
};

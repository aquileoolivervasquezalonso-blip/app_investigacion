
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planes_trabajo', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['Anual', 'Individual'])->default('Individual');
            $table->year('anio')->nullable();
            $table->text('objetivos')->nullable();
            $table->text('actividades')->nullable();
            $table->text('metas')->nullable();
            $table->enum('estado', ['Borrador', 'Enviado', 'Aprobado'])->default('Borrador');
            $table->foreignId('investigador_id')->nullable()->constrained('investigadores')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('planes_trabajo');
    }
};

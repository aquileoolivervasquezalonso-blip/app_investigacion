
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vinculaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['Servicio Tecnológico', 'Consultoría', 'Convenio', 'Transferencia Tecnológica'])->default('Convenio');
            $table->string('institucion')->nullable();
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vinculaciones');
    }
};

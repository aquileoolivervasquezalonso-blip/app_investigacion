
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->enum('tipo', ['Artículo', 'Libro', 'Patente', 'Desarrollo Tecnológico'])->default('Artículo');
            $table->string('autores')->nullable();
            $table->string('medio')->nullable();
            $table->year('anio')->nullable();
            $table->string('doi_isbn')->nullable();
            $table->text('resumen')->nullable();
            $table->foreignId('investigador_id')->nullable()->constrained('investigadores')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publicaciones');
    }
};

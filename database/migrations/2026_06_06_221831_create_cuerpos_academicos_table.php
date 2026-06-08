
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuerpos_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('clave')->nullable();
            $table->enum('grado_consolidacion', ['En Formación', 'En Consolidación', 'Consolidado'])->default('En Formación');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuerpos_academicos');
    }
};

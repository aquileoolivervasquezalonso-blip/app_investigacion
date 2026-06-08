
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('revistas_cientificas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('area_conocimiento')->nullable();
            $table->string('indexacion')->nullable();
            $table->string('issn')->nullable();
            $table->string('enlace')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revistas_cientificas');
    }
};

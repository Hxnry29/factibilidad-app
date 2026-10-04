<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_proyecto');
        $table->decimal('inflacion', 5, 2);
        $table->decimal('tasa_cambio', 10, 2);
        $table->decimal('capex', 15, 2);
        $table->integer('plazo_meses');
        $table->decimal('ingresos', 15, 2);
        $table->decimal('opex', 15, 2);
        $table->string('estado')->default('Borrador');
        $table->timestamps(); // Crea fecha_creacion automáticamente
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};

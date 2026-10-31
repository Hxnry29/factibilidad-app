
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estudios', function (Blueprint $table) {

            // Identificador
            $table->id();

            // Información general
            $table->string('nombre_proyecto');
            $table->string('estado')->default('Guardado');

            // Variables financieras
            $table->decimal('inflacion', 5, 2);
            $table->decimal('tasa_cambio', 10, 2);
            $table->decimal('capex', 15, 2);
            $table->integer('plazo_meses');
            $table->decimal('ingresos', 15, 2);
            $table->decimal('opex', 15, 2);

            // Resultados financieros
            $table->decimal('vpn', 15, 2)->nullable();
            $table->decimal('rcsd', 5, 2)->nullable();

            // Resultados de inteligencia artificial
            $table->decimal('probabilidad_ia', 5, 2)->nullable();
            $table->string('recomendacion_ia')->nullable();

            // Fechas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estudios');
    }
};

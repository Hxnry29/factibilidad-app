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
    Schema::table('estudios', function (Blueprint $table) {
        $table->decimal('vpn', 15, 2)->nullable();
        $table->decimal('rcsd', 5, 2)->nullable();
        $table->decimal('probabilidad_ia', 5, 2)->nullable();
        $table->string('recomendacion_ia')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudios', function (Blueprint $table) {
            //
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de unión entre Productos y Composiciones (Muchos a Muchos)
     */
    public function up(): void
    {
        Schema::create('composition_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('composition_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Opcional: Si quieres eliminar la columna vieja de la tabla products
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign(['composition_id']);
        //     $table->dropColumn('composition_id');
        // });
    }

    public function down(): void
    {
        Schema::dropIfExists('composition_product');
    }
};
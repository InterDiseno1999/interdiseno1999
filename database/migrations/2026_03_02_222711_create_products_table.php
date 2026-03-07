<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla principal de productos textiles.
     * HEMOS ELIMINADO 'composition_id' de aquí porque ahora usamos una tabla pivote.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            
            // LA COLUMNA composition_id SE ELIMINÓ DE AQUÍ
            // ya que la relación ahora es Muchos a Muchos a través de composition_product
            
            $table->string('image'); 
            $table->string('width')->default('1.40');
            
            $table->boolean('stock')->default(true);
            $table->boolean('has_design')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
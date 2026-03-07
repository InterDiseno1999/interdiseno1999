<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabla para las fibras textiles (Algodón, Lino, etc.)
     */
    public function up(): void
    {
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ej: 100% Algodón
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compositions');
    }
};
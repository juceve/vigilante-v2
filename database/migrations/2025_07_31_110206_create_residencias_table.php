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
        Schema::create('residencias', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('cliente_id')->nullable()->constrained('propietarios')->onDelete('cascade');
            $table->foreignId('propietario_id')->nullable()->constrained('propietarios')->onDelete('cascade');
            
            $table->string('cedula_propietario', 20)->nullable();
            $table->string('numeropuerta')->nullable();
            $table->string('calle')->nullable();
            $table->string('nrolote')->nullable();
            $table->string('manzano')->nullable();
            $table->string('notas')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residencias');
    }
};

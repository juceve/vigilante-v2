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
        Schema::create('rrhhdotacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rrhhcontrato_id')->nullable()->constrained()->nullOnDelete();
            $table->date('fecha');
            $table->string('detalle');
            $table->foreignId('rrhhestadodotacion_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('empleado_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('cantidad');            
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhhdotacions');
    }
};

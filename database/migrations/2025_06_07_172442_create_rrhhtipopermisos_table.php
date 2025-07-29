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
        Schema::create('rrhhtipopermisos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nombre_corto');
            $table->float('factor')->nullable();
            $table->string('color',20)->nullable()->default('#FFF');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rrhhtipopermisos');
    }
};

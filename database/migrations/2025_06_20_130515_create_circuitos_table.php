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
        Schema::create('circuitos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pais');
            $table->string('nombre');
            $table->double("latitud1");
            $table->double("longitud1");
            $table->double("latitud2");
            $table->double("longitud2");
            $table->double("latitud3");
            $table->double("longitud3");
            $table->double("latitud4");
            $table->double("longitud4");
            $table->double("latitud5");
            $table->double("longitud5");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circuitos');
    }
};

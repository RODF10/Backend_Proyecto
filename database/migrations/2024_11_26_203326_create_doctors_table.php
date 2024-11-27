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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id(); // Esto define el campo ID como autoincremental
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cedula')->unique();
            $table->string('profesion');
            $table->integer('edad');
            $table->string('genero');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->text('direccion');
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

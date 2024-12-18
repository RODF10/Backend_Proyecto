<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        if (!Schema::hasTable('citas')) {
            Schema::create('citas', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('registration_number');
                $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade')->change();
                $table->date('fecha');
                $table->time('hora');
                $table->timestamps();
            
                // Definir la clave foránea
                $table->foreign('registration_number')
                      ->references('registration_number')
                      ->on('patients')
                      ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

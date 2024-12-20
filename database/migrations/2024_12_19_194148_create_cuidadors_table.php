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
        if(!Schema::hasTable('cuidador')){
            Schema::create('cuidador', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('patient_id'); // Obligatorio y relacionado con 'patients'
                $table->foreign('patient_id') // Relación con 'number_registration' en 'patients'
                      ->references('registration_number')
                      ->on('patients')
                      ->onDelete('cascade'); // Si se elimina el paciente, se eliminan los registros relacionados
                $table->string('cuidador_name')->nullable(); // Opcional
                $table->string('cuidador_lastname')->nullable(); // Opcional
                $table->string('cuidador_phone')->nullable(); // Opcional
                $table->string('cuidador_email')->nullable()->unique(); // Opcional y único
                $table->text('cuidador_address')->nullable(); // Opcional
                $table->timestamps(); // Timestamps para created_at y updated_at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuidador');
    }
};

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
        if(!Schema::hasTable('history_medical')){
            Schema::create('history_medical', function (Blueprint $table) {
                $table->id();
            
                // Relación con la tabla 'patients' (registration_number)
                $table->string('number_imss');
                $table->foreign('number_imss')
                    ->references('registration_number')
                    ->on('patients')
                    ->onDelete('cascade');
                
                // Relación con la tabla 'doctors' (doctor_id)
                $table->foreignId('doctor_id')
                    ->constrained('doctors')
                    ->onDelete('cascade');

                // Relación con la tabla 'diagnostic' (categoria)
                $table->foreignId('diagnostic_id')
                    ->constrained('diagnostic')
                    ->onDelete('cascade');
                
                // Otros campos
                $table->string('encuesta')->nullable(); // Encuesta
                $table->integer('puntos')->default(0); // Puntos de la encuesta
                $table->text('observacion')->nullable(); // Observaciones
                $table->date('fecha'); // Fecha
                $table->time('hora'); // Hora

                $table->timestamps(); // Created at y Updated at
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_medical');
    }
};

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
        Schema::create('patients', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger
            $table->string('registration_number');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('age');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('emergency_contact');
            $table->string('emergency_email');
            $table->string('address');
            $table->text('medical_history')->nullable();
            $table->text('allergies')->nullable();
            $table->string('description');
            $table->unsignedBigInteger('doctor_id'); // Coincide con la clave primaria en "doctors"
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

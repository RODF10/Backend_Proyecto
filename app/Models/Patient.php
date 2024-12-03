<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    /**
     * Campos que pueden ser asignados masivamente.
     */
    protected $fillable = [
        'registration_number', // Matricula
        'first_name',          // Nombre
        'last_name',           // Apellido
        'age',                 // Edad
        'gender',              // Género
        'birth_date',          // Fecha de Nacimiento
        'emergency_contact',   // Contacto de Emergencia
        'emergency_email',     // Email de Emergencia
        'address',             // Domicilio
        'medical_history',     // Antecedentes Patológicos
        'allergies',           // Alergias
        'description',         //Descripcion
        'doctor_id',           // Relación con el doctor
    ];

    /**
     * Relación: un paciente pertenece a un doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
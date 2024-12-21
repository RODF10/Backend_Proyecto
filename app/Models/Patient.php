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
        'gender',              // Género
        'birth_date',          // Fecha de Nacimiento
        'address',             // Domicilio
        'medical_history',     // Antecedentes Patológicos
        'allergies',           // Alergias
        'description',         // Descripcion
        'last_consultation',   //Ultima Consulta 
        'doctor_id',           // Relación con el doctor
    ];

    /**
     * Relación: un paciente pertenece a un doctor.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function histories()
    {
        return $this->hasMany(HistoryMedical::class, 'number_imss', 'registration_number'); // Asegúrate de que 'patient_id' sea la columna correcta
    }
}

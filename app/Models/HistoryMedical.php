<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryMedical extends Model {
    use HasFactory;

    // Definir el nombre de la tabla si no sigue la convención plural
    protected $table = 'history_medical';

    protected $fillable = [
        'number_imss',
        'doctor_id',
        'diagnostic_id',
        'encuesta',
        'puntos',
        'observacion',
        'fecha',
        'hora',
    ];

    // Relación con el modelo 'Doctor'
    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }
     // Relación con el modelo 'Diagnostic'
     public function diagnostic()
     {
         return $this->belongsTo(Diagnostic::class);
     }
    public function patient(){
        return $this->hasOne(Patient::class, 'registration_number', 'number_imss');
    } 
    
}

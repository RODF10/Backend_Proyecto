<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuidador extends Model
{
    use HasFactory;

    protected $table = 'cuidador';

    protected $fillable = [
        'patient_id',
        'cuidador_name',
        'cuidador_lastname',
        'cuidador_phone',
        'cuidador_email',
        'cuidador_address',
    ];

    // Relación con el modelo Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'registration_number');
    }
}

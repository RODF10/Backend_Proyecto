<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cita extends Model {
    use HasFactory;

    protected $fillable = ['registration_number', 'doctor_id', 'fecha', 'hora'];

    public function paciente(){
        return $this->belongsTo(Patient::class, 'registration_number', 'registration_number');
    }

    public function getNombreCompletoAttribute(){
        return "{$this->paciente->first_name} {$this->paciente->last_name}";
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}

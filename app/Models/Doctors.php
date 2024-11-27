<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctors extends Model
{
    use HasFactory;

    /**
     * Los campos que pueden asignarse masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'profesion',
        'edad',
        'genero',
        'email',
        'password',
        'telefono',
        'direccion',
        'imagen',
    ];
}

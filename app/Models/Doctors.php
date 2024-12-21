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
    // Nombre de la tabla (si no sigue la convención por defecto)
    protected $table = 'doctors';
    
    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'profesion',
        'date',
        'genero',
        'email',
        'password',
        'telefono',
        'direccion',
        'imagen',
    ];

    // Ocultar campos sensibles al devolver datos
    protected $hidden = [
        'password', // Oculta la contraseña si no es necesaria
        'created_at',
        'updated_at',
    ];
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctors;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
   // Método para autenticar al doctor
   public function loginDoctor(Request $request)
   {
       // Buscar el usuario por correo electrónico
    $user = Doctors::where('email', $request->email)->first();

    // Verificar si el usuario existe y si la contraseña coincide con el hash
    if ($user && $request->password == $user->password) {
        return response()->json(['message' => 'Contraseña válida'], 200);
    }

    return response()->json(['message' => 'Correo o contraseña incorrectos'], 401);
    }
}

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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Buscar el usuario por correo electrónico
        $user = Doctors::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña coincide con el hash
        if ($user && $request->password == $user->password) {
            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->nombre,  // Enviar el nombre del doctor
                    'apellido' => $user->apellido,
                    'email' => $user->email // Enviar el email si es necesario
                ]
            ], 200);
        }

        return response()->json(['message' => 'Correo o contraseña incorrectos'], 401);
        }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctors;
use App\Models\Patient;
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

   // Método para obtener pacientes relacionados con un doctor
   public function getDoctorPatients($doctorId)
   {
       // Verificar si el doctor existe
       $doctor = Doctors::find($doctorId);

       if (!$doctor) {
           return response()->json(['message' => 'Doctor no encontrado'], 404);
       }

       // Obtener los pacientes relacionados
       $patients = Patient::where('doctor_id', $doctorId)->get();

       return response()->json([
           'success' => true,
           'doctor' => [
               'id' => $doctor->id,
               'nombre' => $doctor->nombre,
               'apellido' => $doctor->apellido,
               'email' => $doctor->email,
           ],
           'patients' => $patients
       ], 200);
   }
}

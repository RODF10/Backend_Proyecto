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
   public function loginDoctor(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        // Buscar el usuario por correo electrónico
        $user = Doctors::where('email', $request->email)->first();

        // Verificar si el usuario existe y si la contraseña coincide con el hash
        if ($user && Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->id,
                    'nombre' => $user->nombre,  // Enviar el nombre del doctor
                    'apellido' => $user->apellido,
                    'email' => $user->email, // Enviar el email si es necesario
                    'imagen' => $user->imagen
                ]
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Correo o contraseña incorrectos'
            ], 401); // 401 Unauthorized
   }

   // Método para obtener pacientes relacionados con un doctor
   public function getDoctorPatients($doctorId) {
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

   
    // Método para cambiar la contraseña
    public function changePassword(Request $request) {
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email|exists:doctors,email',
            'currentPassword' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Encontrar al doctor por correo
        $doctor = Doctors::where('email', $request->correo)->first();
        // Verificar la contraseña actual
        if (!Hash::check($request->currentPassword, $doctor->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual no es válida.'
            ], 401);
        }
        // Actualizar la nueva contraseña
        $doctor->password = Hash::make($request->newPassword);
        // Guardar la contraseña encriptada en la base de datos
        $doctor->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña actualizada con éxito.'
        ], 200);
    }
}

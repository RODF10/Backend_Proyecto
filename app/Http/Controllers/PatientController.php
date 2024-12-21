<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'registration_number' => 'required|string|unique:patients',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'gender' => 'required|string',
                'birth_date' => 'required|date',
                'address' => 'required|string',
                'medical_history' => 'nullable|string',
                'allergies' => 'nullable|string',
                'description' => 'required|string',
                'last_consultation' => 'required|string',
                'doctor_id' => 'required|exists:doctors,id',
            ]);
    
            $patient = Patient::create($validated);
    
            return response()->json($patient, 201);
            
        } catch(\Illuminate\Validation\ValidationException $e) {
            // Captura el error de validación específico de `unique`
            if ($e->errors()['registration_number'] ?? false) {
                return response()->json([
                    'message' => 'El número de registro ya está en uso.',
                    'errors' => $e->errors()
                ], 422);
            }

            // Para otros errores de validación
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $e->errors()
            ], 422);
        }
    }
    public function update(Request $request, $registration_number)
    {
        // Encontrar el paciente por su número de registro
        $patient = Patient::where('registration_number', $registration_number)->first();

        if (!$patient) {
            return response()->json(['error' => 'Paciente no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255', // Cambiado a 'required' si no permite NULL
            'last_name' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'birth_date' => 'required|date',
            'address' => 'required|string|max:255',
            'medical_history' => 'nullable|string', // Opcional
            'allergies' => 'nullable|string',
            'description' => 'nullable|string',
            'registration_number' => 'required|string|max:255', // Validación adicional más abajo
        ]);

        // Verificar si el nuevo número de registro ya existe en otro paciente
        if ($validatedData['registration_number'] != $patient->registration_number) {
            $registrationDuplicate = Patient::where('registration_number', $validatedData['registration_number'])
                ->exists();

            if ($registrationDuplicate) {
                return response()->json(['error' => 'Número de registro duplicado'], 409);
            }
        }

        // Actualizar el paciente
        $patient->update($validatedData);

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Datos del paciente actualizados correctamente', 'patient' => $patient], 200);
    }

    // Obtener un paciente por ID
    public function show($id)
    {
        // Buscar el paciente por el ID
        $patient = Patient::find($id);

        // Verificar si el paciente existe
        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Paciente no encontrado'
            ], 404);  // Retorna un error 404 si no se encuentra
        }

        // Devolver los datos del paciente en formato JSON
        return response()->json([
            'success' => true,
            'patient' => $patient
        ], 200);
    }

    public function destroy($id)
    {
        $patient = Patient::find($id); // Busca el doctor por ID
        if (!$patient) {
            return response()->json(['message' => 'Paciente no encontrado'], 404);
        }

        // Eliminar el doctor
        $patient->delete();

        return response()->json(null, 204);
    }
}

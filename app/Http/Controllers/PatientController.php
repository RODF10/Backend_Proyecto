<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|unique:patients',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'birth_date' => 'required|date',
            'emergency_contact' => 'required|string',
            'emergency_email' => 'required|email',
            'address' => 'required|string',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'description' => 'required|string',
            'last_consultation' => 'required|string',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $patient = Patient::create($validated);

        return response()->json($patient, 201);
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

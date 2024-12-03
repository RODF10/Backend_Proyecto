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
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $patient = Patient::create($validated);

        return response()->json($patient, 201);
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

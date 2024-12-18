<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctors;
use App\Models\Cita;
use Illuminate\Http\Request;

class CitaController extends Controller{
    public function index($doctorId){
        return Cita::where('doctor_id', $doctorId)->with('paciente:id,registration_number,first_name,last_name')->get()->map(function ($cita) {
            return [
                'id' => $cita->id, // Incluye el ID aquí
                'registration_number' => $cita->registration_number,
                'nombre_completo' => $cita->paciente->first_name . ' ' . $cita->paciente->last_name,
                'fecha' => $cita->fecha,
                'hora' => $cita->hora,
            ];
        });
    }

    public function getPacientes(){
        return Paciente::all();
    }

     // Crear una nueva cita
     public function store(Request $request) {
         $request->validate([
             'registration_number' => 'required|exists:patients,registration_number',
             'doctor_id' => 'required|exists:doctors,id',
             'fecha' => 'required|date',
             'hora' => 'required|date_format:H:i',
         ]);
 
         $cita = Cita::create([
             'registration_number' => $request->registration_number,
             'doctor_id' => $request->doctor_id,
             'fecha' => $request->fecha,
             'hora' => $request->hora,
         ]);
 
         return response()->json(['message' => 'Cita creada correctamente', 'cita' => $cita->load('paciente')], 201);
     }

     public function pacientesPorDoctor($doctorId) {
        return Patient::where('doctor_id', $doctorId)->get(['registration_number', 'first_name', 'last_name']);
    }
    // Eliminar una cita
    public function destroy($id){
        $cita = Cita::find($id);

        if (!$cita) {
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        $cita->delete();
        return response()->json(['message' => 'Cita eliminada correctamente']);
    }
    // Filtrar citas próximas (conforme pase la hora)
    public function citasProximas() {
        $now = now();
        $citas = Cita::where(function ($query) use ($now) {
            $query->where('fecha', '>', $now->toDateString())
                  ->orWhere(function ($q) use ($now) {
                      $q->where('fecha', $now->toDateString())
                        ->where('hora', '>', $now->toTimeString());
                  });
        })->with('paciente:id,first_name,last_name,registration_number')->get();

        return response()->json($citas);
    }
}
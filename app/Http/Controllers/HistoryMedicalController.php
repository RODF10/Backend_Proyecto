<?php

namespace App\Http\Controllers;

use App\Models\HistoryMedical;
use App\Models\Doctors;
use App\Models\Diagnostic;
use Illuminate\Http\Request;

class HistoryMedicalController extends Controller {
    // Método para guardar un nuevo registro
    public function store(Request $request) {
        $request->validate([
            'number_imss' => 'required|string|max:15',
            'doctor_id' => 'required|exists:doctors,id',
            'diagnostic_id' => 'required|exists:diagnostic,id',
            'encuesta' => 'required|string',
            'puntos' => 'required|integer',
            'observacion' => 'required|string',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i:s',
        ]);

        $historyMedical = HistoryMedical::create([
            'number_imss' => $request->number_imss,
            'doctor_id' => $request->doctor_id,
            'diagnostic_id' => $request->diagnostic_id,
            'encuesta' => $request->encuesta,
            'puntos' => $request->puntos,
            'observacion' => $request->observacion,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
        ]);

        return response()->json(['message' => 'Registro de historia médica creado', 'data' => $historyMedical], 201);
    }
     // Método para obtener todos los registros
     public function index() {
         $historyMedicals = HistoryMedical::with(['doctor', 'diagnostic'])->get();
         return response()->json($historyMedicals);
     }
 
     // Método para obtener un registro específico
     public function show($id) {
         $historyMedical = HistoryMedical::with(['doctor', 'diagnostic'])->findOrFail($id);
         return response()->json($historyMedical);
     }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuidador;


class CuidadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuidadores = Cuidador::with('patient')->get(); // Trae cuidadores junto con sus pacientes
        return view('cuidadors.index', compact('cuidadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,number_registration', // Obligatorio y debe existir
            'cuidador_name' => 'nullable|string|max:255',
            'cuidador_lastname' => 'nullable|string|max:255',
            'cuidador_phone' => 'nullable|string|max:15',
            'cuidador_email' => 'nullable|email|unique:cuidadors',
            'cuidador_address' => 'nullable|string',
        ]);
    
        Cuidador::create($validated);
    
        return redirect()->route('cuidadors.index')->with('success', 'Cuidador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $patient_id)
    {
        // Buscar al cuidador por el patient_id
        $cuidador = Cuidador::where('patient_id', $patient_id)->first();
        // Si no se encuentra el cuidador, retornar un error
        if (!$cuidador) {
            return response()->json(['message' => 'Cuidador no encontrado'], 404);
        }
        // Validación de los datos recibidos
        $validated = $request->validate([
            'patient_id' => [
                'required',
                'exists:patients,registration_number',
                function ($attribute, $value, $fail) use ($cuidador) {
                    // Validar que no haya otro cuidador con el mismo patient_id
                    $existe = Cuidador::where('patient_id', $value)
                        ->where('id', '!=', $cuidador->id) // Excluir al cuidador actual
                        ->exists();
            
                    if ($existe) {
                        $fail('El patient_id ya está asignado a otro cuidador.');
                    }
                }
            ],
            'cuidador_name' => 'nullable|string|max:255',
            'cuidador_lastname' => 'nullable|string|max:255',
            'cuidador_phone' => 'nullable|string|max:15',
            'cuidador_email' => 'nullable|email|unique:cuidador,cuidador_email,' . $cuidador->patient_id . ',patient_id',
            'cuidador_address' => 'nullable|string',
        ]);
        // Excluir el campo patient_id de la actualización, ya que no debe cambiar
        unset($validated['patient_id']);

        // Actualizar los campos con los datos validados
        $cuidador->update($validated);
        // Verificar si los datos fueron actualizados
        if ($cuidador->wasChanged()) {
            // Retornar una respuesta exitosa en formato JSON
            return response()->json([
                'message' => 'Cuidador actualizado exitosamente.',
                'data' => $cuidador,
            ], 200);
        } else {
            return response()->json(['message' => 'No se realizaron cambios'], 400);
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuidador $cuidador)
    {
        $cuidador->delete();

        return redirect()->route('cuidadors.index')->with('success', 'Cuidador eliminado exitosamente.');
    }
    public function getCuidadorByPatientId($patient_id) {
        // Buscar al cuidador relacionado con el patient_id
        $cuidador = Cuidador::where('patient_id', $patient_id)->first();

        // Si no se encuentra el cuidador, retornar un error
        if (!$cuidador) {
            return response()->json(['message' => 'Cuidador no encontrado'], 404);
        }

        // Retornar los datos del cuidador
        return response()->json([
            'message' => 'Datos del cuidador obtenidos exitosamente.',
            'cuidador' => $cuidador,
        ], 200);
    }

}

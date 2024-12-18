<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Doctors::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // NO SE USA
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'cedula' => 'required|string|unique:doctors',
            'profesion' => 'required|string|max:35',
            'date' => 'required|date',
            'edad' => 'required|integer',
            'genero' => 'required|string|max:10',
            'email' => 'required|email|unique:doctors',
            'password' => 'required|string|min:6',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'required|string',
            'imagen' => 'nullable|string',
        ]);
        
        $data = $request->all();

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $data['imagen'] = 'images/' . $filename;
        }

        $doctor = Doctors::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'cedula' => $request->cedula,
            'profesion' => $request->profesion,
            'date' => $request->date,
            'edad' => $request->edad,
            'genero' => $request->genero,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'imagen' => $request->imagen,
        ]);

        return response()->json($doctor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Buscar al doctor por ID
            $doctor = Doctors::find($id);

            // Retornar datos del doctor en formato JSON
            return response()->json([
                'success' => true,
                'data' => $doctor,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Manejar caso de no encontrar el doctor
            return response()->json([
                'success' => false,
                'message' => 'Doctor no encontrado',
            ], 404);
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los datos del doctor',
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Doctors $doctors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Doctors $doctors)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'nullable|string|max:255',
            'apellido' => 'nullable|string|max:255',
            'cedula' => 'nullable|string|unique:doctors,cedula,' . $doctors->id,
            'profesion' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'genero' => 'nullable|string|max:10',
            'email' => 'nullable|email|unique:doctors,email,' . $doctors->id,
            'password' => 'nullable|string|min:6',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string',
            'imagen' => 'nullable|string',
        ]);

        // Actualizar el doctor
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }

        $doctor->update($validatedData);

        return response()->json($doctors, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = Doctors::find($id); // Busca el doctor por ID
        if (!$doctor) {
            return response()->json(['message' => 'Doctor no encontrado'], 404);
        }

        // Eliminar el doctor
        $doctor->delete();

        return response()->json(null, 204);
    }
}

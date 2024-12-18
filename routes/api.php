<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CitaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// DOCTORES
Route::get('/doctors', [DoctorsController::class, 'index']);
Route::post('/doctors', [DoctorsController::class, 'store']);
Route::get('/doctors{id}', [DoctorsController::class, 'show']);
Route::put('/doctors/{doctor}', [DoctorsController::class, 'update']);
Route::delete('/doctors/{id}', [DoctorsController::class, 'destroy']);
Route::resource('doctors', DoctorsController::class);
Route::post('/change-password', [AuthController::class, 'changePassword']); // Ruta para cambiar la contraseña
Route::post('/validate-password', [AuthController::class, 'loginDoctor']);
Route::get('checkCedula/{cedula}/{id?}', [DoctorsController::class, 'checkCedula']); // Check Cedula

// PACIENTES
Route::post('/add-patients', [PatientController::class, 'store']);
Route::get('/doctor{doctorId}/patients', [AuthController::class, 'getDoctorPatients']);
Route::get('patients/{id}', [PatientController::class, 'show']);
Route::delete('patients/{id}', [PatientController::class, 'destroy']);
Route::resource('patients', PatientController::class);

// CITA DEL DOCTOR DEL PACIENTE
Route::get('/citas/{doctorId}', [CitaController::class, 'index']); // Listar citas del Doctor
Route::get('/pacientes/{doctorId}', [CitaController::class, 'pacientesPorDoctor']); // Listar pacientes del doctor
Route::post('citas', [CitaController::class, 'store']); // Crea Nuvea Cita
Route::delete('/citas/{id}', [CitaController::class, 'destroy']); // Eliminar una cita
Route::get('/citas-proximas', [CitaController::class, 'citasProximas']); // Obtener citas futuras
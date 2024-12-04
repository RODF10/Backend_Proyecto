<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// DOCTORES
Route::get('/doctors', [DoctorsController::class, 'index']);
Route::post('/doctors', [DoctorsController::class, 'store']);
Route::get('/doctors/{id}', [DoctorsController::class, 'show']);
Route::put('/doctors/{id}', [DoctorsController::class, 'update']);
Route::delete('/doctors/{id}', [DoctorsController::class, 'destroy']);
Route::resource('doctors', DoctorsController::class);

Route::post('/validate-password', [AuthController::class, 'loginDoctor']);

// PACIENTES
Route::post('/add-patients', [PatientController::class, 'store']);
Route::get('/{doctorId}/patients', [AuthController::class, 'getDoctorPatients']);
Route::get('patients/{id}', [PatientController::class, 'show']);
Route::delete('patients/{id}', [PatientController::class, 'destroy']);
Route::resource('patients', PatientController::class);
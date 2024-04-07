<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;

Route::get('/api/vehiculos', [VehiculoController::class, 'getAll'])->name('api_vehiculos.getAll');
Route::get('/api/vehiculos/{id}', [VehiculoController::class, 'getId'])->name('api_vehiculos.getId');
Route::post('/api/vehiculos/create', [VehiculoController::class, 'create'])->name('api_vehiculos.create');
Route::put('/api/vehiculos/update/{id}', [VehiculoController::class, 'update'])->name('api_vehiculos.update');
Route::delete('/api/vehiculos/delete/{id}', [VehiculoController::class, 'delete'])->name('api_vehiculos.delete');
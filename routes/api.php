<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\EquipoController;
use App\Http\Controllers\API\V1\NivelController;
use App\Http\Controllers\API\V1\SueldoController;

Route::prefix("v1")->group(function(){
    Route::apiResource('equipos',              EquipoController::class)->only(['index','show', 'store', 'update', 'destroy']);
    Route::apiResource('niveles',              NivelController::class)->only(['index','show', 'store', 'update', 'destroy']);

    Route::post('sueldos',                     [SueldoController::class, 'sueldo_completo']);
});

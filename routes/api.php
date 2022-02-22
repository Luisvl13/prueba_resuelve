<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\V1\EquipoController;
use App\Http\Controllers\API\V1\NivelController;

Route::prefix("v1")->group(function(){
    Route::apiResource('equipos',              EquipoController::class)->only(['index','show', 'store', 'update', 'destroy']);
    Route::apiResource('niveles',              NivelController::class)->only(['index','show', 'store', 'update', 'destroy']);
});


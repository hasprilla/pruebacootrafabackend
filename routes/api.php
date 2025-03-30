<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;


Route::middleware(['api'])->group(function () {
    Route::apiResource('products', ProductoController::class);
    Route::apiResource('inventary', InventarioController::class);
});

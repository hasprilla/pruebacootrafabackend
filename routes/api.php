<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::middleware(['api'])->group(function () {
    Route::apiResource('products', ProductoController::class);
});

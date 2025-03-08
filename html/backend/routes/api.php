<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::prefix('/properties')->group(function () {
    Route::get('/', [PropertyController::class, 'getProperties']);
});

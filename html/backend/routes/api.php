<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::prefix('/properties')->group(function () {
    Route::get('/', [PropertyController::class, 'getProperties']);
});

Route::fallback(function (Request $request) {
    return response()->json([
        'exception' => 'Not Found',
        'message' => 'This API route does not exist.',
    ], 404);
});

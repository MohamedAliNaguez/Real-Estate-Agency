<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('properties/search', [PropertyController::class, 'search']);
Route::get('properties/nearby', [PropertyController::class, 'nearby']);
Route::apiResource('properties', PropertyController::class);

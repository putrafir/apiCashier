<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\KeranjangsController;
use App\Http\Controllers\PesanansController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('categories', CategoriesController::class);
Route::apiResource('products', ProductsController::class);
Route::apiResource('keranjangs', KeranjangsController::class);
Route::apiResource('pesanans', PesanansController::class);

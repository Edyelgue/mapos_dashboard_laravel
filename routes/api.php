<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaposController;
use App\Http\Controllers\VendasPorVendedorController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('dados-banco', [
    MaposController::class, 
    'index'
]);

Route::get('/vendas', [
    VendasPorVendedorController::class, 
    'index'
]);

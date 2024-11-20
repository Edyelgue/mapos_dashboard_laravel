<?php

use App\Http\Controllers\VendasPorVendedorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vendas', [
    VendasPorVendedorController::class,
    'index'
])->name('vendas.index');
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendasPorVendedorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth', 'verified'])->group(function () {
    // Rota Dashboard redirecionando para Vendas
    Route::get('/dashboard', function () {
        return redirect()->route('vendas.index');
    })->name('dashboard');

    // Rota para Vendas
    Route::get('/vendas', [VendasPorVendedorController::class, 'index'])
        ->name('vendas.index');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('dados-banco', [MaposController::class,'index']);
});

require __DIR__.'/auth.php';

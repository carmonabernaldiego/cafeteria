<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\VentaController;

Route::get('/', function () {
    return redirect()->route('productos.index');
});


Route::resource('categorias', CategoriaController::class);


Route::resource('productos', ProductoController::class);

Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');

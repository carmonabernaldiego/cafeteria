<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return redirect()->route('productos.index');
});


Route::resource('categorias', CategoriaController::class);


Route::resource('productos', ProductoController::class);

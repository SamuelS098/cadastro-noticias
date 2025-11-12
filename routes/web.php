<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\NoticiaController;

// 🏠 Página inicial → redireciona para Categorias
Route::get('/', function () {
    return redirect()->route('categorias.index');
});

// 📁 CRUD de Categorias
Route::resource('categorias', CategoriaController::class);

// 📰 CRUD de Notícias
Route::resource('noticias', NoticiaController::class);

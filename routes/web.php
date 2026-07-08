<?php

use Illuminate\Support\Facades\Route;

// Главная страница
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Если у вас уже есть другие маршруты, они должны быть после этого

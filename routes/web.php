<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\TimelineController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Главная
Route::get('/', function () {
    return view('welcome');
})->name('home');

// О проекте
Route::get('/about', [PageController::class, 'about'])->name('about');

// ===== АВТОРИЗАЦИЯ =====
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ===== ЛИЧНЫЙ КАБИНЕТ =====
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'showPasswordForm'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

// ===== ПЕРСОНАЖИ =====
Route::resource('characters', CharacterController::class);

// Хронология
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
Route::get('/timeline/{timeline}', [TimelineController::class, 'show'])->name('timeline.show');

// ===== ХРОНОЛОГИЯ =====
// ===== ВАЖНО: ИСПОЛЬЗУЙТЕ ЭТОТ ВАРИАНТ! =====
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
Route::get('/timeline/create', [TimelineController::class, 'create'])->name('timeline.create');
Route::post('/timeline', [TimelineController::class, 'store'])->name('timeline.store');
Route::get('/timeline/{timeline}', [TimelineController::class, 'show'])->name('timeline.show');
Route::get('/timeline/{timeline}/edit', [TimelineController::class, 'edit'])->name('timeline.edit');
Route::put('/timeline/{timeline}', [TimelineController::class, 'update'])->name('timeline.update');
Route::delete('/timeline/{timeline}', [TimelineController::class, 'destroy'])->name('timeline.destroy');

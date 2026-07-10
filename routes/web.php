<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PrivateMessageController;
use App\Http\Controllers\SearchController;

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

// ===== ХРОНОЛОГИЯ =====
// !!! ВАЖНО: /create ДОЛЖЕН БЫТЬ ПЕРВЫМ !!!
Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline.index');
Route::get('/timeline/create', [TimelineController::class, 'create'])->name('timeline.create');
Route::post('/timeline', [TimelineController::class, 'store'])->name('timeline.store');
Route::get('/timeline/{timeline}', [TimelineController::class, 'show'])->name('timeline.show');
Route::get('/timeline/{timeline}/edit', [TimelineController::class, 'edit'])->name('timeline.edit');
Route::put('/timeline/{timeline}', [TimelineController::class, 'update'])->name('timeline.update');
Route::delete('/timeline/{timeline}', [TimelineController::class, 'destroy'])->name('timeline.destroy');

// ===== ЧАТ =====
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/rules', [ChatController::class, 'rules'])->name('chat.rules'); // или использовать index
    Route::post('/chat/agree', [ChatController::class, 'agree'])->name('chat.agree');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

    // Управление баном (только для модераторов и админов)
    Route::post('/chat/ban/{user}', [ChatController::class, 'banUser'])->name('chat.ban')
        ->middleware('role:moderator,admin');
    Route::post('/chat/unban/{user}', [ChatController::class, 'unbanUser'])->name('chat.unban')
        ->middleware('role:moderator,admin');
});
// ===== ЛИЧНЫЕ СООБЩЕНИЯ =====
Route::middleware('auth')->prefix('dm')->name('dm.')->group(function () {
    Route::get('/', [PrivateMessageController::class, 'index'])->name('index');
    Route::get('/{user}', [PrivateMessageController::class, 'show'])->name('show');
    Route::post('/send', [PrivateMessageController::class, 'store'])->name('send');
    Route::get('/unread/count', [PrivateMessageController::class, 'unreadCount'])->name('unread');
});
// ===== ПОИСК =====
Route::get('/search', [SearchController::class, 'index'])->name('search');

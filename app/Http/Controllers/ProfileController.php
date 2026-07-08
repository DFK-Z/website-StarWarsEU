<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Показать личный кабинет
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Показать форму редактирования профиля
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Обновить профиль
     */
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // Обновляем основные данные
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Обновляем аватарку
    if ($request->hasFile('avatar')) {
        // Удаляем старую аватарку
        $user->clearMediaCollection('avatar');
        // Добавляем новую
        $user->addMedia($request->file('avatar'))
            ->toMediaCollection('avatar');
    }

    return redirect()->route('profile')->with('success', 'Профиль успешно обновлён!');
}

    /**
     * Показать форму смены пароля
     */
    public function showPasswordForm()
    {
        $user = Auth::user();
        return view('profile.password', compact('user'));
    }

    /**
     * Обновить пароль
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Проверка текущего пароля
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Текущий пароль неверен.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')->with('success', 'Пароль успешно изменён!');
    }
}

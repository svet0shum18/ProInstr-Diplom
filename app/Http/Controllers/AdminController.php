<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function login(Request $request)
    {
        // Валидируем данные формы
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Попытка аутентификации
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)) {
            // Если аутентификация успешна, перенаправляем на dashboard
            return redirect()->route('admin.dashboard');
        }

        // Если ошибка, возвращаем с ошибкой
        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ]);
    }
}


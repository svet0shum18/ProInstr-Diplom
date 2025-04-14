<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            // Если пользователь подтвердил email
            if (Auth::user()->hasVerifiedEmail()) {
                return redirect()->intended('/profile'); // Личный кабинет
            } else {
                Auth::logout();
                return redirect()->route('verification.notice'); // Перенаправление на страницу подтверждения почты
            }
        }

        return back()->withErrors([
            'email' => 'Неверные данные для входа',
        ]);
    }

    /**
     * Выход пользователя.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Проверяем, является ли пользователь администратором
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);  // Если админ, продолжаем выполнение запроса
        }

        // Если не админ, перенаправляем на главную страницу или другую страницу
        return redirect('/');
    }
}

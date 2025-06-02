<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

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
        if (
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ], $request->remember)
        ) {
            // Если аутентификация успешна, перенаправляем на dashboard
            return redirect()->route('admin.dashboard');
        }

        // Если ошибка, возвращаем с ошибкой
        return back()->withErrors([
            'email' => 'Неверный логин или пароль.',
        ]);
    }

    // ОТОБРАЖЕНИЕ ЗАКАЗОВ

    public function index(Request $request)
    {
        $orders = Order::query()
        ->when($request->has('status'), function ($query) use ($request) {
            return $query->where('status', $request->status);
        })
        ->with(['user', 'items'])
        ->latest()
        ->paginate(10);

    return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,processing,completed,cancelled'
        ]);

        $order->update($validated);

        return redirect()
            ->route('admin.orders.show', $order->id)
            ->with('success', 'Статус заказа обновлен');
    }

}


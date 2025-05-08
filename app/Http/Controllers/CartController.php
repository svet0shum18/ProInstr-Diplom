<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\DB;



class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        // Получаем товар по ID
        $product = Product::findOrFail($id);

        // Проверяем, что товар в наличии
        if ($product->quantity < 1) {
            return response()->json(['error' => 'Товар закончился'], 400);
        }

        // Находим или создаем позицию в корзине
        $cartItem = Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $id],
            ['quantity' => 0]
        );

        $cartItem->quantity += 1;
        $cartItem->save();

        // Уменьшаем количество товара на складе
        $product->quantity -= 1;
        $product->save();

        return response()->json(['message' => 'Товар добавлен в корзину']);
    }

    public function index()
    {
        // Получаем все товары из корзины для текущего пользователя
        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();

        // Считаем общую сумму
        $totalSum = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
        
        return view('cart.index', [
            'cartItems' => $cartItems,
            'totalSum' => $totalSum,
            'isEmpty' => $cartItems->isEmpty() // Добавляем флаг пустой корзины
        ]);
    }


    public function updateQuantity(Request $request, $id)
    {
        $cart = Cart::findOrFail($id); // Находим запись в корзине

        $change = (int) $request->input('change', 0);

        // Получаем товар
        $product = Product::findOrFail($cart->product_id);

        // Увеличиваем или уменьшаем количество
        if ($change === 1 && $product->quantity > 0) {
            $cart->quantity += 1;
            $product->quantity -= 1;
        } elseif ($change === -1 && $cart->quantity > 1) {
            $cart->quantity -= 1;
            $product->quantity += 1;
        }

        $cart->save();
        $product->save();


        // Пересчитываем общую сумму корзины
        $totalSum = Cart::with('product')
            ->where('user_id', auth()->id())  // Убедитесь, что берем только корзину текущего пользователя
            ->get()->sum(function ($cartItem) {
                return $cartItem->quantity * $cartItem->product->price;
            });

        // Перезагружаем корзину с новыми данными
        return redirect()->route('cart.index')->with([
            'cartItems' => Cart::all(),
            'totalSum' => $totalSum
        ]);
    }

    public function remove($id)
    {
        // Находим товар в корзине по product_id и user_id
        $cartItem = Cart::where('product_id', $id)->where('user_id', auth()->id())->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Товар не найден в корзине.']);
        }

        if ($cartItem) {
            // Вернем количество обратно в таблицу products
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $product->quantity += $cartItem->quantity;
                $product->save();
            }
        }


        // Удаляем товар из корзины
        $cartItem->delete();

        // Пересчитываем общую сумму корзины
        $totalSum = Cart::with('product')
            ->where('user_id', auth()->id())  // Убедитесь, что берем только корзину текущего пользователя
            ->get()->sum(function ($cartItem) {
                return $cartItem->quantity * $cartItem->product->price;
            });

        $cartItems = Cart::where('user_id', auth()->id())->with('product')->get();


        // Перенаправляем обратно на страницу корзины с обновленными данными
        return redirect()->route('cart.index')->with(compact('cartItems', 'totalSum'));
    }

    private function calculateTotal()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return $total;
    }

}
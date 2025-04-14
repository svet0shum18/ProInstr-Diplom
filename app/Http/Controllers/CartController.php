<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Product $product)
    {
        // Логика для добавления товара в корзину (используем сессию)
        $cart = session()->get('cart', []);

        // Если товар уже есть в корзине, увеличиваем его количество
        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
            ];
        }

        // Сохраняем корзину в сессии
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Товар добавлен в корзину');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    
}

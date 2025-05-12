<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Cart;


class ProductController extends Controller
{
      public function showChainsaws(Request $request)
{
    $query = Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->with('brand'); ;

    $brands = Brand::whereHas('products', function($query) {
        $query->whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'));
    })->orderBy('name')->get();

    // Фильтр по цене
    if ($request->price_min) {
        $query->where('price', '>=', $request->price_min);
    }
    if ($request->price_max) {
        $query->where('price', '<=', $request->price_max);
    }
    

      // Фильтр по бренду
    if ($request->filled('brand')) {
        $query->whereHas('brand', function($q) use ($request) {
            $q->where('name', $request->brand);
        });
    }
    
    // Фильтр по мощности
    if ($request->power) {
        $power = (float)$request->power;
        if ($power == 1.5) {
            $query->where('power', '<=', 1.5);
        } elseif ($power == 5) {
            $query->where('power', '>', 3.5);
        } else {
            $query->whereBetween('power', [
                $power - 1,
                $power
            ]);
        }
    }
    
    // Фильтр по весу
    if ($request->weight) {
        $weight = (float)$request->weight;
        if ($weight == 4) {
            $query->where('weight', '<=', 4);
        } elseif ($weight == 7) {
            $query->where('weight', '>', 6);
        } else {
            $query->whereBetween('weight', [
                $weight - 1,
                $weight
            ]);
        }
    }
    $priceRange = [
    'min' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->min('price'),
    'max' => Product::whereHas('toolType', fn($q) => $q->where('name', 'Бензопилы'))->max('price')
];
    
    // Получаем общее количество после всех фильтров
    $totalCount = $query->count();
    
    $products = $query->paginate(12)->appends($request->query());
    
    return view('products.chainsaw', compact('products', 'totalCount','brands'));
}

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

    public function show($id)
{
    $product = Product::with('category','brand')->findOrFail($id);
    return view('products.show', compact('product'));   
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function addFavorite(Product $product)
    {
        $user = Auth::user();

        //no dublicate
        if (!Favorite::where('user_id', $user->id)->where('product_id', $product->id)->exists())
        {
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        return redirect()->back()->with('succes','Товар добавлен в избранное!');
    }

    public function remove(Product $product)
{
    $user = Auth::user();

    $favorite = Favorite::where('user_id', $user->id)
                        ->where('product_id', $product->id)
                        ->first();

    if ($favorite) {
        $favorite->delete();
    }

    return redirect()->back()->with('success', 'Товар удалён из избранного.');
}


    public function index()
    {
        
        $favorites = Favorite::with('product')->where('user_id', Auth::id())->get();
        $favoritesCount = Favorite::where('user_id', Auth::id())->count();

        return view('favorites.index', compact('favorites', 'favoritesCount'));
    }
}

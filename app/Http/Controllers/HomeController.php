<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ToolType;
use App\Models\Product;

class HomeController extends Controller
{
  public function index()
  {
     $chainsaws = Product::whereHas('toolType', function($query) {
            $query->where('name', 'Бензопилы');
        })
        ->limit(5)
        ->get();

        return view('welcome', [
        'chainsaws' => $chainsaws // или $randomProducts, или $popularProducts
    ]);
  }
}

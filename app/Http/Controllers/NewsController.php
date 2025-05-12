<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryNews;
use App\Models\News;

class NewsController extends Controller
{
    public function index()  {

 
        $news = News::with('category')->orderBy('created_at','desc')->take(9)->get();

        $categories = CategoryNews::all();


        return view('welcome', [
            'news' => $news,
            'categories' => $categories // Передаем категории в вид
        ]);

    }


    public function show($id)
{
     $article = News::with('category')->findOrFail($id);
     return view('news.show', compact('article'));
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryNews;
use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {


        $news = News::with('category')->orderBy('created_at', 'desc')->take(9)->get();

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


    // СОЗДАНИЕ НОВОСТЕЙ АДМИН

    public function indexAdmin()
    {
        $news = News::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function createNews()
    {
        $categories = CategoryNews::all();
        return view('admin.news.create', compact('categories'));
    }

    public function store(Request $request)
{
    \Log::info('Starting news creation'); // Добавьте эту строку

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'description' => 'required|string|max:500',
        'text' => 'required|string',
        'category_id' => 'required|exists:category_news,id'
    ]);

    try {
        // Обработка изображения
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $filename = time().'_'.Str::slug($image->getClientOriginalName());
            $path = 'news/'.$filename;
            
            // Сохраняем в storage/app/public/news
            Storage::disk('public')->put($path, file_get_contents($image));
            $validated['img'] = $path;
            
            \Log::info('Image saved to: '.$path);
        }

        // Создание новости
        $news = News::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'text' => $validated['text'],
            'img' => $validated['img'],
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['title']),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        \Log::info('News created with ID: '.$news->id);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно создана');

    } catch (\Exception $e) {
        \Log::error('Error creating news: '.$e->getMessage());
        return back()->withInput()->with('error', 'Ошибка: '.$e->getMessage());
    }
}



    public function showAdmin(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

     public function edit(News $news)
    {
        $categories = CategoryNews::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

     public function update(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:news_categories,id',
            'is_published' => 'sometimes|boolean'
        ]);


        // Обновляем slug только если изменился заголовок
        if ($news->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Обновляем дату публикации
        if ($request->boolean('is_published') && !$news->is_published) {
            $validated['published_at'] = now();
        } elseif (!$request->boolean('is_published')) {
            $validated['published_at'] = null;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно обновлена');
    }

    public function destroy(News $news)
    {

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Новость успешно удалена');
    }


}

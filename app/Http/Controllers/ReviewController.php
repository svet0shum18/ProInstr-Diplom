<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Product;

use Illuminate\Support\Facades\Auth; // Добавляем фасад Auth
use App\Policies\ReviewPolicy; // Подключаем политику

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000',
            'photos.*' => 'required|mimes:jpeg,png,jpg|max:2048'
        ]);

        $review = new Review([
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false

        ]);

        //обработка фото
        if ($request->hasFile('photos')) {
            $photos = [];
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');

                $photos[] = $path;
            }

            $review->photos = $photos;
        }

        $product->reviews()->save($review);

        return back()->with('success', 'Отзыв отпралвен на модерацию');
    }

    // Страница отзывов пользователя
    public function userReviews()
    {
        $reviews = Auth::user()->reviews()
            ->with('product')
            ->latest()
            ->paginate(10);

        return view('user.reviews', compact('reviews'));
    }

    // Удаление отзыва
    public function destroy(Review $review)
    {
        // Проверка прав через политику (альтернатива authorize)
        if (Auth::id() !== $review->user_id) {
            abort(403, 'У вас нет прав на это действие');
        }

        $review->delete();

        return back()->with('success', 'Отзыв удалён');
    }

    // Обновление отзыва
    public function update(Request $request, Review $review)
    {
        // Проверка прав
        if (Auth::id() !== $review->user_id) {
            abort(403, 'У вас нет прав на это действие');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10|max:1000'
        ]);

        $review->update($validated);

        return redirect()->route('users.reviews')->with('success', 'Отзыв успешно обновлён!');
    }


    // АДМИН МОДЕРАЦИЯ

    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->where('is_approved', false)
            ->latest()
            ->paginate(10);

        $noReviews = $reviews->isEmpty();

        return view('admin.reviews.index', compact('reviews','noReviews'));
    }

    // Одобрить отзыв
    public function approve(Review $review)
    {
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Отзыв одобрен и опубликован');

        
    }

    // Отклонить отзыв
    // public function reject(Review $review)
    // {
    //     $review->update(['is_approved' => false]);

    //     return back()->with('warning', 'Отзыв отклонен');
    // }
}

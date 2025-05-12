<?php

use App\Http\Controllers\UserController;
use App\Models\Favorite;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OneCExchangeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsController;
use App\Models\Product;



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [NewsController::class, 'index']);

// Отображение новостей
Route::get('/news/{id}/{slug?}', [NewsController::class, 'show'])->name('news.show');



// ROOTIK
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::put('/dashboard/update-name', [UserController::class, 'updateName'])->name('dashboard.update.name');
    Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('profile.destroy');

    // КОРЗИНА
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.orderuser');

    // ПРОФИЛЬ ЗАКАЗЫ
    // Просмотр заказа
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    // Удаление заказа
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');


    // СОХРАНЕНИЕ АДРЕСА ДОСТАВКИ
    Route::get('/get-saved-delivery-data', [OrderController::class, 'getLast'])->name('delivery.last');


    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // ИЗБАРННОЕ
    Route::post('/favorite/{product}', [FavoriteController::class, 'addFavorite'])->name('favorite.add');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::delete('/favorite/{product}', [FavoriteController::class, 'remove'])->name('favorite.remove');


    // ------------------------------------------ТОВАРЫ-----------------------------------------------------

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    // Бензопилы
    Route::get('/benzopily', [ProductController::class, 'showChainsaws'])->name('products.chainsaw');


});

Route::middleware('guest')->group(function () {
    Route::get('register', [UserController::class, 'create'])->name('register');//показ формы регистрации
    Route::post('register', [UserController::class, 'store'])->name('user.store');

    Route::get('login', [UserController::class, 'login'])->name('login');
    Route::post('login', [UserController::class, 'loginAuth'])->name('login.auth');

    Route::get('forgot-pawwsord', function () {
        return view('user.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [UserController::class, 'forgotPasswordStore'])->name('password.email')
        ->middleware('throttle:3,1');

    Route::get('reset-password/{token}', function (string $token) {
        return view('user.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('reset-password', [UserController::class, 'resetPasswordUpdate'])->name('password.update');


});



Route::middleware('auth')->group(function () {

    Route::get('verify-email', function () {
        return view('user.verify-email');
    })->name('verification.notice');


    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('dashboard');
    })->middleware('signed')->name('verification.verify');


    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Ссылка для подтверждения отправлена!');
    })->middleware('throttle:6,1')->name('verification.send');

    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

});



























// Route::get('/', function () {
//     $products = Product::all(); // Получаем все товары из базы данных
//     return view('welcome', compact('products'));
// });

// Route::get('/cart', [CartController::class, 'showCart'])->name('cart');


// Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
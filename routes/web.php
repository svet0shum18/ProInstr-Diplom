<?php

use App\Http\Controllers\ReviewController;
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
    Route::get('/dashboard/orders', [OrderController::class, 'index'])->name('order.index');

    // ПРОФИЛЬ ЗАКАЗЫ
    // Просмотр заказа
    Route::get('dashboard/orders/{order}', [OrderController::class, 'show'])->name('order.show');
    // Удаление заказа
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    //Просмотр отзывов
    Route::get('/dashboard/reviews', [ReviewController::class, 'userReviews'])->name('user.reviews');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');


    // СОХРАНЕНИЕ АДРЕСА ДОСТАВКИ
    Route::get('/get-saved-delivery-data', [OrderController::class, 'getLast'])->name('delivery.last');


    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // ИЗБАРННОЕ
    Route::post('/favorite/{product}', [FavoriteController::class, 'addFavorite'])->name('favorite.add');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::delete('/favorite/{product}', [FavoriteController::class, 'remove'])->name('favorite.remove');


    // ------------------------------------------ТОВАРЫ-----------------------------------------------------

    // Поиск товаров
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/brand/{id}', [ProductController::class, 'byBrand'])->name('products.brands');

    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

    //-------------------------------------------Бензоинструменты----------------------------------------------
    // Бензопилы
    Route::get('/benzopily', [ProductController::class, 'showChainsaws'])->name('products.chainsaw');
    //Генераторы
    Route::get('/generators', [ProductController::class, 'showGenerator'])->name('products.generator');
    //Бензорезы
    Route::get('/benzorezy', [ProductController::class, 'showBenzorez'])->name('products.benzorez');
    //Мотопомпы
    Route::get('/motopomp', [ProductController::class, 'showPomp'])->name('products.pomp');
    //-------------------------------------------Климатическое оборудование------------------------------------
    // Кондиционеры
    Route::get('/conditioners', [ProductController::class, 'showConditioners'])->name('products.conditioners');
    // Кондиционеры
    Route::get('/waterheater', [ProductController::class, 'showWaterheater'])->name('products.waterheaters');
    // Обогреватели
    Route::get('/heater', [ProductController::class, 'showHeater'])->name('products.heaters');



    





    // ------------------------------------------ОТЗЫВЫ-----------------------------------------------------
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');




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



// ROOTIK
Route::middleware(['auth', 'is_admin'])->name('admin.')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::resource('orders', AdminController::class)
        ->only(['index', 'show', 'update']);

    // НОВОСТИ
    Route::get('/news', [NewsController::class, 'indexAdmin'])->name('news.index');

    Route::get('/admin/news/create', [NewsController::class, 'createNews'])->name('news.create');

    Route::post('/news', [NewsController::class, 'store'])->name('news.store');

    Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');

    Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');

    Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

    Route::get('/news/{news}', [NewsController::class, 'showAdmin'])->name('news.show');



    // ОТЗЫВЫ
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');

    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');

    Route::post('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');

    // ТОВАРЫ
    Route::get('/admin/products/create', [ProductController::class, 'createProduct'])->name('products.create');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');




});


























// Route::get('/', function () {
//     $products = Product::all(); // Получаем все товары из базы данных
//     return view('welcome', compact('products'));
// });

// Route::get('/cart', [CartController::class, 'showCart'])->name('cart');


// Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
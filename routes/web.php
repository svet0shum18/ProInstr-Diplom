<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Models\Product;


Route::get('/', function () {
    return view('welcome');
});

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
    

    Route::post('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

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



























Route::get('/', function () {
    $products = Product::all(); // Получаем все товары из базы данных
    return view('welcome', compact('products'));
});

// Route::get('/cart', [CartController::class, 'showCart'])->name('cart');


// Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
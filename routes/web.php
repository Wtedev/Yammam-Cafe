<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SuggestionController as AdminSuggestionController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// صفحات القائمة والمنتجات
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');

// السلة
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// الطلبات (تتطلب تسجيل دخول)
Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::post('/', [OrderController::class, 'store'])->name('store');
    Route::patch('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// الاقتراحات والشكاوى
Route::prefix('suggestions')->name('suggestions.')->group(function () {
    Route::get('/', [SuggestionController::class, 'index'])->name('index');
    Route::get('/create', [SuggestionController::class, 'create'])->name('create');
    Route::post('/', [SuggestionController::class, 'store'])->name('store');
    Route::get('/{suggestion}', [SuggestionController::class, 'show'])->name('show')->middleware('auth');
});

// Dashboard للمستخدمين المسجلين
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// ==== لوحة الإدارة ====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // الصفحة الرئيسية
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // إدارة المنتجات (نظام CRUD كامل)
    // Route::get('/products', function () {
    //     return view('admin.products');
    // })->name('products');

    // إدارة الطلبات (لايوت فقط)
    Route::get('/orders', function () {
        return view('admin.orders');
    })->name('orders');

    // إدارة المنتجات (نظام CRUD كامل)
    Route::resource('products', AdminProductController::class);
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/toggle-availability', [AdminProductController::class, 'toggleAvailability'])->name('products.toggle-availability');
    Route::patch('/products/{product}/toggle-featured', [AdminProductController::class, 'toggleFeatured'])->name('products.toggle-featured');


    // إدارة المستخدمين
    Route::resource('users', AdminUserController::class);
    Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggle-role');

    // الملف الشخصي للأدمن
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('profile');

    // إدارة الاقتراحات
    Route::prefix('suggestions')->name('suggestions.')->group(function () {
        Route::get('/', [AdminSuggestionController::class, 'index'])->name('index');
        Route::get('/{suggestion}', [AdminSuggestionController::class, 'show'])->name('show');
        Route::patch('/{suggestion}/status', [AdminSuggestionController::class, 'updateStatus'])->name('update-status');
        Route::patch('/{suggestion}/mark-read', [AdminSuggestionController::class, 'markAsRead'])->name('mark-read');
        Route::post('/bulk-action', [AdminSuggestionController::class, 'bulkAction'])->name('bulk-action');
        Route::delete('/{suggestion}', [AdminSuggestionController::class, 'destroy'])->name('destroy');
    });
});

// ==== API Routes للـ AJAX ====
Route::prefix('api')->name('api.')->group(function () {

    // API المنتجات
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/search', [ApiProductController::class, 'search'])->name('search');
        Route::get('/categories', [ApiProductController::class, 'categories'])->name('categories');
        Route::get('/types', [ApiProductController::class, 'types'])->name('types');
        Route::get('/featured', [ApiProductController::class, 'featured'])->name('featured');
        Route::get('/popular', [ApiProductController::class, 'popular'])->name('popular');
    });

    // API الطلبات
    Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
        Route::get('/{order}/status', [ApiOrderController::class, 'status'])->name('status');
        Route::get('/{order}/tracking', [ApiOrderController::class, 'tracking'])->name('tracking');
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', function () {
        return view('profile.show');
    })->name('profile.show');
});

require __DIR__ . '/auth.php';

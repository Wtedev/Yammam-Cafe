<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\EnsureCheckoutAuthenticated;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');

// صفحات القائمة والمنتجات
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{product}', [MenuController::class, 'show'])->name('menu.show');

// روت مختصر للسلة
Route::get('/cart', [CartController::class, 'index'])->name('cart');

// السلة
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::post('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// صفحة الدفع (تتطلب تسجيل دخول)
Route::middleware(['auth', EnsureCheckoutAuthenticated::class])->prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// الطلبات (تتطلب تسجيل دخول)
Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/{order}', [OrderController::class, 'show'])->name('show');
    Route::patch('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
});

// الاقتراحات والشكاوى
Route::prefix('suggestions')->name('suggestions.')->group(function () {
    Route::get('/', [SuggestionController::class, 'index'])->name('index');
    Route::get('/create', [SuggestionController::class, 'create'])->name('create');
    Route::post('/', [SuggestionController::class, 'store'])->name('store');
    Route::get('/{suggestion}', [SuggestionController::class, 'show'])->name('show')->middleware('auth');
});

// ==== صفحات المستخدم العادي ====
Route::middleware(['auth'])->group(function () {
    // صفحة طلباتي
    Route::get('/my-orders', function () {
        $user = Auth::user();
        $orders = $user->orders()->orderByDesc('created_at')->paginate(10);
        $activeCount = $user->orders()->whereIn('status', ['pending', 'confirmed', 'processed'])->count();
        return view('user.orders', compact('orders', 'activeCount'));
    })->name('my-orders');

    // صفحة اقتراحاتي
    Route::get('/my-suggestions', function () {
        $user = Auth::user();
        $suggestions = $user->suggestions()->orderByDesc('created_at')->paginate(10);
        return view('user.suggestions', compact('suggestions'));
    })->name('my-suggestions');

    // صفحة البروفايل للمستخدم
    Route::get('/user/profile', [App\Http\Controllers\User\ProfileController::class, 'show'])->name('user.profile');
    Route::patch('/user/profile', [App\Http\Controllers\User\ProfileController::class, 'update'])->name('user.profile.update');
});

// ==== لوحة الإدارة ====
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // الصفحة الرئيسية
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // إدارة المنتجات (نظام CRUD كامل)
    // Route::get('/products', function () {
    //     return view('admin.products');
    // })->name('products');

    // إدارة الطلبات
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');

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
    Route::patch('/profile/update', [AdminUserController::class, 'updateProfile'])->name('profile.update');

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

require __DIR__ . '/auth.php';

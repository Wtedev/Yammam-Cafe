<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات هذا الأسبوع
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $weeklyStats = [
            'orders' => Order::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            'revenue' => Order::whereBetween('created_at', [$weekStart, $weekEnd])
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),
            'products' => Product::count(),
            'suggestions' => Suggestion::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            'new_orders' => Order::new()->count(),
            'new_suggestions' => Suggestion::unviewed()->count(),
        ];

        // أحدث 5 طلبات
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // أحدث 3 طلبات جديدة
        $newOrders = Order::new()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // أحدث 5 اقتراحات
        $recentSuggestions = Suggestion::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // أحدث 3 اقتراحات جديدة
        $newSuggestions = Suggestion::unviewed()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'weeklyStats',
            'recentOrders',
            'recentSuggestions',
            'newOrders',
            'newSuggestions'
        ));
    }
}

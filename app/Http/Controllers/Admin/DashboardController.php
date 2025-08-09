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
        // إحصائيات اليوم
        $todayStats = [
            'orders' => Order::whereDate('created_at', today())->count(),
            'revenue' => Order::whereDate('created_at', today())
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),
            'new_users' => User::whereDate('created_at', today())->count(),
            'suggestions' => Suggestion::whereDate('created_at', today())->count(),
        ];

        // إحصائيات الشهر
        $monthStats = [
            'orders' => Order::whereMonth('created_at', now()->month)->count(),
            'revenue' => Order::whereMonth('created_at', now()->month)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),
            'new_users' => User::whereMonth('created_at', now()->month)->count(),
            'suggestions' => Suggestion::whereMonth('created_at', now()->month)->count(),
        ];

        // الطلبات الحديثة
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // المنتجات الأكثر طلباً
        $topProducts = Product::orderBy('order_count', 'desc')
            ->take(5)
            ->get();

        // الاقتراحات الجديدة
        $newSuggestions = Suggestion::where('status', 'new')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // إحصائيات الطلبات حسب الحالة
        $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // المبيعات اليومية لآخر 7 أيام
        $dailySales = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('created_at', '>=', now()->subDays(7))
            ->where('status', '!=', 'cancelled')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'todayStats',
            'monthStats',
            'recentOrders',
            'topProducts',
            'newSuggestions',
            'ordersByStatus',
            'dailySales'
        ));
    }
}

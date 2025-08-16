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
        // حدود الأسبوع الحالي (لبعض المؤشرات فقط)
        $weekStart = now()->startOfWeek(); // افتراضي: الإثنين. غيّره لإعدادات محلية إن لزم
        $weekEnd = now()->endOfWeek();

        // بداية آخر يوم أحد (حسب الطلب)
        $lastSunday = now()->startOfWeek()->subDay(); // الأحد قبل الإثنين الافتراضي
        // إن أردت جعل الأحد هو بداية الأسبوع دائماً:
        // $lastSunday = now()->setISODate((int)now()->format('o'), (int)now()->format('W'), 7)->startOfDay();

        $weeklyStats = [
            // طلبات هذا الأسبوع (أي حالة)
            'orders' => Order::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            // المبيعات منذ آخر أحد: نجمع كل الحالات غير الملغية
            'revenue' => Order::where('created_at', '>=', $lastSunday)
                ->where('status', '!=', 'cancelled')
                ->sum('total_price'),
            // عدد المنتجات المتاحة
            'products' => Product::where('is_available', true)->count(),
            // اقتراحات هذا الأسبوع
            'suggestions' => Suggestion::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            // الطلبات الجديدة: جميع غير المقروءة غير مقيّدة بالأسبوع
            'new_orders' => Order::new()->count(),
            // الاقتراحات الجديدة: جميع غير المقروءة غير مقيّدة بالأسبوع
            'new_suggestions' => Suggestion::unviewed()->count(),
        ];

        // جميع الطلبات غير المقروءة (كل الوقت)
        $newOrders = Order::new()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // جميع الاقتراحات غير المقروءة (كل الوقت)
        $newSuggestions = Suggestion::unviewed()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // لم تعد أقسام "أحدث الطلبات/الاقتراحات" مستخدمة في الواجهة
        $recentOrders = collect();
        $recentSuggestions = collect();

        return view('admin.dashboard', compact(
            'weeklyStats',
            'recentOrders',
            'recentSuggestions',
            'newOrders',
            'newSuggestions'
        ));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // البحث العام في جميع الحقول
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%')
                                  ->orWhere('office_number', 'like', '%' . $request->search . '%')
                                  ->orWhere('mobile', 'like', '%' . $request->search . '%');
                    });
            });
        }

        // البحث القديم للتوافق مع الكود الموجود
        if ($request->user_search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_search . '%')
                    ->orWhere('mobile', 'like', '%' . $request->user_search . '%');
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $statusCounts = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        // إحصائيات الطلبات الجديدة
        $newOrdersCount = Order::new()->count();
        $newOrders = Order::new()->latest()->take(5)->get();

        return view('admin.orders', compact('orders', 'statusCounts', 'newOrdersCount', 'newOrders'));
    }

    public function show(Order $order)
    {
        // تحديث حالة أول مشاهدة للطلب
        if (is_null($order->first_viewed_at)) {
            $order->update([
                'first_viewed_at' => now(),
                'first_viewed_by' => Auth::id(),
            ]);
        }

        $order->load('user');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processed,delivered,cancelled',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $order->status;

        $order->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at' => now()
        ]);

        // إذا تم إلغاء الطلب، قلل عداد الطلبات للمنتجات
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $productsData = $order->products_data;
            if ($productsData) {
                foreach ($productsData as $productData) {
                    $product = \App\Models\Product::find($productData['id']);
                    if ($product) {
                        $product->decrement('order_count', $productData['quantity']);
                    }
                }
            }
        }

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        // تقليل عداد الطلبات للمنتجات إذا لم يكن الطلب ملغى مسبقاً
        if ($order->status !== 'cancelled') {
            foreach ($order->products as $product) {
                $product->decrement('order_count', $product->pivot->quantity);
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    public function stats()
    {
        $today = now()->startOfDay();
        $thisWeek = now()->startOfWeek();
        $thisMonth = now()->startOfMonth();

        $stats = [
            'today' => [
                'orders' => Order::where('created_at', '>=', $today)->count(),
                'revenue' => Order::where('created_at', '>=', $today)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount'),
                'completed' => Order::where('created_at', '>=', $today)
                    ->where('status', 'completed')
                    ->count(),
            ],
            'week' => [
                'orders' => Order::where('created_at', '>=', $thisWeek)->count(),
                'revenue' => Order::where('created_at', '>=', $thisWeek)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount'),
                'completed' => Order::where('created_at', '>=', $thisWeek)
                    ->where('status', 'completed')
                    ->count(),
            ],
            'month' => [
                'orders' => Order::where('created_at', '>=', $thisMonth)->count(),
                'revenue' => Order::where('created_at', '>=', $thisMonth)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_amount'),
                'completed' => Order::where('created_at', '>=', $thisMonth)
                    ->where('status', 'completed')
                    ->count(),
            ]
        ];

        return view('admin.orders.stats', compact('stats'));
    }
}

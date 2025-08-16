<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
                    ->orWhereHas('user', function ($userQuery) use ($request) {
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

        $data = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at' => now(),
        ];
        // ضبط وقت التسليم عند التحويل إلى "تم التسليم" وإلغاءه خلاف ذلك
        if ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            $data['delivery_time'] = now();
        } elseif ($oldStatus === 'delivered' && $request->status !== 'delivered') {
            $data['delivery_time'] = null;
        }

        $order->update($data);

        // إذا تم إلغاء الطلب، قلل عداد الطلبات للمنتجات (مع دعم جميع الأشكال المحتملة للبيانات)
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $raw = $order->products;
            if (is_string($raw)) {
                $decoded = json_decode($raw, true) ?: [];
            } elseif (is_array($raw)) {
                $decoded = $raw;
            } else {
                $decoded = [];
            }
            $items = $decoded['items'] ?? $decoded; // دعم الشكل { items: [...] } أو مصفوفة مباشرة

            if (is_array($items)) {
                foreach ($items as $productData) {
                    if (!is_array($productData)) continue;
                    $id = $productData['id'] ?? $productData['product_id'] ?? null;
                    $qty = (int)($productData['quantity'] ?? 0);
                    if ($id && $qty > 0) {
                        $product = \App\Models\Product::find($id);
                        if ($product) {
                            $dec = min($qty, max(0, (int)$product->order_count));
                            if ($dec > 0) {
                                $product->decrement('order_count', $dec);
                            }
                        }
                    }
                }
            }
        }

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        if ($order->status !== 'cancelled') {
            $raw = $order->products;
            if (is_string($raw)) {
                $decoded = json_decode($raw, true) ?: [];
            } elseif (is_array($raw)) {
                $decoded = $raw;
            } else {
                $decoded = [];
            }
            $items = $decoded['items'] ?? $decoded; // دعم الشكل القديم
            foreach ($items as $productData) {
                if (isset($productData['id'])) {
                    $product = \App\Models\Product::find($productData['id']);
                    if ($product) $product->decrement('order_count', $productData['quantity'] ?? 0);
                }
            }
        }
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'تم حذف الطلب بنجاح');
    }
}

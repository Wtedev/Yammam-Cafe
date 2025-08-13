<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->orderBy('created_at', 'desc')->paginate(10);
        // إذا لم يكن القالب موجوداً يمكن إنشاءه لاحقاً
        return view()->exists('orders.index') ? view('orders.index', compact('orders')) : abort(404, 'orders.index view missing');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        $raw = $order->products; // قد تكون مصفوفة بالفعل بسبب cast
        if (is_string($raw)) {
            $decoded = json_decode($raw, true) ?: [];
        } elseif (is_array($raw)) {
            $decoded = $raw;
        } else {
            $decoded = [];
        }
        $order->products_items = $decoded['items'] ?? [];
        $order->products_meta = $decoded['meta'] ?? [];
        return view()->exists('orders.show') ? view('orders.show', compact('order')) : abort(404, 'orders.show view missing');
    }

    public function store(Request $request)
    {
        return redirect()->route('checkout.index')->with('error', 'يرجى إتمام الطلب من صفحة الدفع');
    }

    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'لا يمكن إلغاء هذا الطلب');
        }
        $raw = $order->products;
        if (is_string($raw)) {
            $decoded = json_decode($raw, true) ?: [];
        } elseif (is_array($raw)) {
            $decoded = $raw;
        } else {
            $decoded = [];
        }
        $items = $decoded['items'] ?? [];
        foreach ($items as $productData) {
            $product = \App\Models\Product::find($productData['id']);
            if ($product) $product->decrement('order_count', $productData['quantity']);
        }
        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'تم إلغاء الطلب بنجاح');
    }
}

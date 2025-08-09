<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $orders = Auth::user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // التأكد من أن الطلب ينتمي للمستخدم الحالي
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // تحويل المنتجات من JSON إلى مصفوفة
        $order->products_data = json_decode($order->products, true);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500',
            'delivery_time' => 'nullable|date_format:H:i'
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'السلة فارغة');
        }

        DB::beginTransaction();

        try {
            // إنشاء الطلب
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => 0,
                'status' => 'pending',
                'notes' => $request->notes,
                'delivery_time' => $request->delivery_time,
            ]);

            $totalAmount = 0;

            // إضافة المنتجات للطلب
            foreach ($cart as $productId => $quantity) {
                $product = Product::findOrFail($productId);

                if (!$product->is_available) {
                    throw new \Exception("المنتج {$product->name} غير متاح حالياً");
                }

                $subtotal = $product->price * $quantity;
                $totalAmount += $subtotal;

                $order->products()->attach($productId, [
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal
                ]);

                // تحديث عداد الطلبات للمنتج
                $product->increment('order_count', $quantity);
            }

            // تحديث المبلغ الإجمالي
            $order->update(['total_amount' => $totalAmount]);

            // إفراغ السلة
            Session::forget('cart');

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'تم إرسال طلبك بنجاح! رقم الطلب: ' . $order->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        // التأكد من أن الطلب ينتمي للمستخدم الحالي
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // التأكد من أن الطلب قابل للإلغاء
        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'لا يمكن إلغاء هذا الطلب');
        }

        DB::beginTransaction();

        try {
            // تقليل عداد الطلبات للمنتجات
            $orderProducts = json_decode($order->products, true);
            foreach ($orderProducts as $productData) {
                $product = Product::find($productData['id']);
                if ($product) {
                    $product->decrement('order_count', $productData['quantity']);
                }
            }

            // تحديث حالة الطلب
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return back()->with('success', 'تم إلغاء الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'حدث خطأ أثناء إلغاء الطلب');
        }
    }
}

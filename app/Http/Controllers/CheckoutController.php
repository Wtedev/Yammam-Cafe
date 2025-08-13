<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول قبل إتمام الطلب');
        }
        $cartItems = session('cart', []);
        if (empty($cartItems)) return redirect()->route('cart.index')->with('error', 'لا يمكن المتابعة للدفع والسلة فارغة');
        $total = 0;
        $cartProducts = [];
        foreach ($cartItems as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_available) {
                $subtotal = $product->price * $quantity;
                $total += $subtotal;
                $cartProducts[] = ['product' => $product, 'quantity' => $quantity, 'subtotal' => $subtotal];
            }
        }
        if (empty($cartProducts)) return redirect()->route('cart.index')->with('error', 'لا توجد منتجات متاحة في السلة');
        $bankInfo = ['bank_name' => 'البنك الأهلي السعودي', 'account_number' => 'SA1234567890123456789012', 'account_holder' => 'يمام كافيه', 'iban' => 'SA1234567890123456789012'];
        // Debug معلومات للمطور (يمكن إزالتها لاحقاً)
        Log::debug('Checkout index debug', [
            'user_id' => Auth::id(),
            'cart_count' => count($cartItems),
            'total_calc' => $total,
        ]);
        return view('checkout.index', compact('cartProducts', 'total', 'bankInfo'));
    }

    public function store(Request $request)
    {
        $traceId = uniqid('ord_');
        Log::info('Checkout start', ['trace' => $traceId, 'user_id' => Auth::id(), 'ip' => $request->ip()]);
        try {
            $baseRules = [
                'name' => 'required|string|max:255',
                'office_number' => 'required|string|max:50',
                'payment_method' => 'required|in:bank_transfer,network,cash',
                'notes' => 'nullable|string|max:500'
            ];
            if ($request->payment_method === 'bank_transfer') {
                $baseRules['receipt_image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:4096';
            } else {
                $baseRules['receipt_image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096';
            }
            $request->validate($baseRules, [
                'receipt_image.required' => 'صورة الإيصال مطلوبة عند اختيار التحويل البنكي'
            ]);

            $cartItems = session('cart', []);
            if (empty($cartItems)) {
                Log::warning('Empty cart on checkout', ['trace' => $traceId]);
                return redirect()->route('cart.index')->with(['error' => 'لا يمكن إنهاء الطلب والسلة فارغة', 'trace' => $traceId]);
            }

            $total = 0;
            $pivotData = [];
            $items = [];
            foreach ($cartItems as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product && $product->is_available) {
                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;
                    $pivotData[$productId] = ['quantity' => $quantity, 'unit_price' => $product->price, 'subtotal' => $subtotal];
                    $items[] = ['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'quantity' => $quantity, 'subtotal' => $subtotal];
                } else {
                    Log::warning('Product unavailable skipped', ['trace' => $traceId, 'product_id' => $productId]);
                }
            }
            if (empty($items)) {
                Log::warning('No valid items after filtering', ['trace' => $traceId]);
                return redirect()->route('cart.index')->with(['error' => 'لا توجد منتجات متاحة في السلة', 'trace' => $traceId]);
            }

            $receiptPath = null;
            if ($request->hasFile('receipt_image')) {
                $receiptPath = $request->file('receipt_image')->store('receipts', 'public');
                Log::info('Receipt uploaded', ['trace' => $traceId, 'path' => $receiptPath]);
            }

            $meta = [
                'customer_name' => $request->name,
                'notes' => $request->notes,
                'placed_at' => now()->toDateTimeString(),
                'trace' => $traceId,
                'user_agent' => $request->userAgent(),
            ];

            $order = Order::create([
                'user_id' => Auth::id(),
                'office_number' => $request->office_number,
                'products' => ['items' => $items, 'meta' => $meta],
                'total_price' => $total,
                'order_time' => now(),
                'payment_method' => $request->payment_method,
                'payment_image_url' => $receiptPath,
                'status' => 'pending'
            ]);

            foreach ($pivotData as $pid => $data) {
                $order->products()->attach($pid, $data);
            }
            session()->forget('cart');
            Log::info('Order created successfully', ['trace' => $traceId, 'order_id' => $order->id, 'total' => $total]);
            return redirect()->route('orders.show', $order)->with(['success' => 'تم إنشاء طلبك بنجاح! رقم الطلب: ' . $order->id, 'trace' => $traceId]);
        } catch (\Throwable $e) {
            Log::error('Checkout failed', [
                'trace' => $traceId,
                'user_id' => Auth::id(),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'stack' => $e->getTraceAsString()
            ]);
            return back()->withInput()->with([
                'error' => 'حدث خطأ غير متوقع أثناء إنشاء الطلب. كود التتبع: ' . $traceId,
                'trace' => $traceId
            ]);
        }
    }
}

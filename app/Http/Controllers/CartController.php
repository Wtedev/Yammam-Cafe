<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $totalQuantity = 0;
        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_available) {
                $subtotal = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                $total += $subtotal;
                $totalQuantity += $quantity;
                $totalPrice += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'total', 'totalQuantity', 'totalPrice'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1|max:10'
        ]);

        if (!$product->is_available) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذا المنتج غير متاح حالياً'
                ], 400);
            }
            return back()->with('error', 'هذا المنتج غير متاح حالياً');
        }

        $cart = Session::get('cart', []);
        $productId = $product->id;
        $quantity = $request->quantity ?? 1;

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // حد أقصى 10 قطع من نفس المنتج
        if ($cart[$productId] > 10) {
            $cart[$productId] = 10;
        }

        Session::put('cart', $cart);

        // حساب إجمالي عدد العناصر في السلة
        $cartCount = array_sum($cart);
        $cartTotal = $this->calculateCartTotal($cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إضافة المنتج إلى السلة بنجاح',
                'cart_count' => $cartCount,
                'cart_total' => number_format($cartTotal, 2),
                'product_name' => $product->name
            ]);
        }

        return back()->with('success', 'تم إضافة المنتج إلى السلة بنجاح');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:10'
        ]);

        $cart = Session::get('cart', []);
        $quantity = $request->quantity;

        if ($quantity == 0) {
            unset($cart[$productId]);
        } else {
            $cart[$productId] = $quantity;
        }

        Session::put('cart', $cart);

        // حساب ملخص السلة
        $totalQuantity = array_sum($cart);
        $totalPrice = $this->calculateCartTotal($cart);
        $product = Product::find($productId);
        $product_price = $product ? $product->price : 0;

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث السلة بنجاح',
            'totalQuantity' => $totalQuantity,
            'totalPrice' => $totalPrice,
            'product_price' => $product_price
        ]);
    }

    public function remove(Request $request, $productId)
    {
        try {
            Log::info('Cart remove called', [
                'productId' => $productId,
                'method' => $request->method(),
                'is_ajax' => $request->ajax(),
                'headers' => $request->headers->all()
            ]);

            $cart = Session::get('cart', []);
            Log::info('Current cart', ['cart' => $cart]);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                Session::put('cart', $cart);

                // حساب ملخص السلة
                $totalQuantity = array_sum($cart);
                $totalPrice = $this->calculateCartTotal($cart);

                Log::info('Cart after removal', [
                    'cart' => $cart,
                    'totalQuantity' => $totalQuantity,
                    'totalPrice' => $totalPrice
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'تم حذف المنتج من السلة',
                        'totalQuantity' => $totalQuantity,
                        'totalPrice' => $totalPrice
                    ]);
                }
                return back()->with('success', 'تم حذف المنتج من السلة');
            }

            Log::warning('Product not found in cart', ['productId' => $productId, 'cart' => $cart]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'المنتج غير موجود في السلة'
                ]);
            }
            return back()->with('error', 'المنتج غير موجود في السلة');
        } catch (\Exception $e) {
            Log::error('Cart remove error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'productId' => $productId
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'حدث خطأ أثناء حذف المنتج');
        }
    }

    public function clear(Request $request)
    {
        Session::forget('cart');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إفراغ السلة بنجاح',
                'totalQuantity' => 0,
                'totalPrice' => 0
            ]);
        }

        return back()->with('success', 'تم إفراغ السلة بنجاح');
    }

    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum($cart);

        return response()->json(['count' => $count]);
    }

    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->is_available) {
                $total += $product->price * $quantity;
            }
        }
        return $total;
    }
}

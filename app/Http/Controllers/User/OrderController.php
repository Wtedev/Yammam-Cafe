<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->orders();

        // البحث النصي
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', $searchTerm)
                    ->orWhere('office_number', 'like', $searchTerm)
                    ->orWhereHas('products', function ($productQuery) use ($searchTerm) {
                        $productQuery->where('name', 'like', $searchTerm);
                    });
            });
        }

        // تصفية حسب الحالة
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // تصفية حسب التاريخ من
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        // تصفية حسب التاريخ إلى
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderByDesc('created_at')->paginate(10);
        $activeCount = $user->orders()->whereIn('status', ['pending', 'confirmed', 'processed'])->count();

        return view('user.orders', compact('orders', 'activeCount'));
    }

    public function show(Order $order)
    {
        // التأكد من أن الطلب يخص المستخدم الحالي
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }
}

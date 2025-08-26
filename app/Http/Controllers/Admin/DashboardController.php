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

        return view('admin.dashboard', compact(
            'newOrders',
            'newSuggestions'
        ));
    }
}

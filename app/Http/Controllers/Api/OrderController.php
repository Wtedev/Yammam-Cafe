<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function status(Order $order)
    {
        // التأكد من أن الطلب ينتمي للمستخدم الحالي أو المدير
        if (!Auth::check() || (Auth::user()->role !== 'admin' && $order->user_id !== Auth::id())) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        return response()->json([
            'id' => $order->id,
            'status' => $order->status,
            'status_text' => $this->getStatusText($order->status),
            'created_at' => $order->created_at->format('Y-m-d H:i'),
            'estimated_time' => $this->getEstimatedTime($order->status)
        ]);
    }

    public function tracking(Order $order)
    {
        // التأكد من أن الطلب ينتمي للمستخدم الحالي
        if (!Auth::check() || $order->user_id !== Auth::id()) {
            return response()->json(['error' => 'غير مصرح'], 403);
        }

        $statusHistory = [
            'pending' => ['text' => 'تم استلام الطلب', 'completed' => true, 'time' => $order->created_at],
            'confirmed' => ['text' => 'تم تأكيد الطلب', 'completed' => false, 'time' => null],
            'preparing' => ['text' => 'جاري التحضير', 'completed' => false, 'time' => null],
            'ready' => ['text' => 'جاهز للاستلام', 'completed' => false, 'time' => null],
            'completed' => ['text' => 'تم التسليم', 'completed' => false, 'time' => null]
        ];

        $currentStatuses = ['pending', 'confirmed', 'preparing', 'ready', 'completed'];
        $currentIndex = array_search($order->status, $currentStatuses);

        if ($currentIndex !== false) {
            for ($i = 0; $i <= $currentIndex; $i++) {
                $statusHistory[$currentStatuses[$i]]['completed'] = true;
                if ($i === $currentIndex) {
                    $statusHistory[$currentStatuses[$i]]['time'] = $order->updated_at;
                }
            }
        }

        return response()->json([
            'order_id' => $order->id,
            'current_status' => $order->status,
            'status_history' => $statusHistory,
            'estimated_completion' => $this->getEstimatedTime($order->status)
        ]);
    }

    private function getStatusText($status)
    {
        $statusTexts = [
            'pending' => 'في الانتظار',
            'confirmed' => 'مؤكد',
            'preparing' => 'قيد التحضير',
            'ready' => 'جاهز',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغى'
        ];

        return $statusTexts[$status] ?? 'غير معروف';
    }

    private function getEstimatedTime($status)
    {
        $estimatedMinutes = [
            'pending' => 5,
            'confirmed' => 15,
            'preparing' => 10,
            'ready' => 0,
            'completed' => 0,
            'cancelled' => 0
        ];

        $minutes = $estimatedMinutes[$status] ?? 0;
        return $minutes > 0 ? now()->addMinutes($minutes)->format('H:i') : null;
    }
}

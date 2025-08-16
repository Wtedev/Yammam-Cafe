<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->suggestions();

        // البحث النصي
        if ($request->has('search') && $request->search != '') {
            $searchTerm = '%' . $request->search . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->where('suggestion', 'like', $searchTerm)
                    ->orWhere('name', 'like', $searchTerm);
            });
        }

        // تصفية حسب النوع
        if ($request->has('type') && $request->type != '') {
            $query->where('type', $request->type);
        }

        // تصفية حسب الحالة
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $suggestions = $query->orderByDesc('created_at')->paginate(10);

        return view('user.suggestions', compact('suggestions'));
    }
}

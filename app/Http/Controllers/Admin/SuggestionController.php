<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index(Request $request)
    {
        $query = Suggestion::with('user');

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('suggestion', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('mobile', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $suggestions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.suggestions.index', compact('suggestions'));
    }

    public function show(Suggestion $suggestion)
    {
        // تحديث حالة أول مشاهدة للاقتراح
        if (is_null($suggestion->first_viewed_at)) {
            $suggestion->update([
                'first_viewed_at' => now(),
                'first_viewed_by' => Auth::id(),
            ]);
        }

        return view('admin.suggestions.show', compact('suggestion'));
    }

    public function updateStatus(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'status' => 'required|in:new,reviewing,approved,rejected,implemented',
        ]);

        $suggestion->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'تم تحديث حالة الاقتراح بنجاح');
    }

    public function destroy(Suggestion $suggestion)
    {
        $suggestion->delete();

        return redirect()->route('admin.suggestions.index')
            ->with('success', 'تم حذف الاقتراح بنجاح');
    }

    public function markAsRead(Suggestion $suggestion)
    {
        if ($suggestion->status === 'new') {
            $suggestion->update(['status' => 'reviewing']);
        }

        return back()->with('success', 'تم وضع علامة قيد المراجعة');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'suggestions' => 'required|array',
            'action' => 'required|in:mark_reviewed,mark_responded,delete'
        ]);

        $suggestions = Suggestion::whereIn('id', $request->suggestions);

        switch ($request->action) {
            case 'mark_reviewed':
                $suggestions->update(['status' => 'reviewing']);
                $message = 'تم وضع علامة قيد المراجعة على الاقتراحات المحددة';
                break;

            case 'mark_responded':
                $suggestions->update(['status' => 'approved', 'responded_at' => now()]);
                $message = 'تم وضع علامة موافق عليه على الاقتراحات المحددة';
                break;

            case 'delete':
                $suggestions->delete();
                $message = 'تم حذف الاقتراحات المحددة';
                break;

            default:
                $message = 'عملية غير معروفة';
        }

        return back()->with('success', $message);
    }
}

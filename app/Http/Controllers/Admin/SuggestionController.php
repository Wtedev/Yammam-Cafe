<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use Illuminate\Http\Request;

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
                    ->orWhere('mobile', 'like', '%' . $request->search . '%')
                    ->orWhere('suggestion', 'like', '%' . $request->search . '%');
            });
        }

        $suggestions = $query->orderBy('created_at', 'desc')->paginate(20);

        $typeCounts = Suggestion::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        $statusCounts = Suggestion::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.suggestions.index', compact('suggestions', 'typeCounts', 'statusCounts'));
    }

    public function show(Suggestion $suggestion)
    {
        return view('admin.suggestions.show', compact('suggestion'));
    }

    public function updateStatus(Request $request, Suggestion $suggestion)
    {
        $request->validate([
            'status' => 'required|in:new,reviewed,responded,closed',
            'admin_response' => 'nullable|string|max:1000'
        ]);

        $suggestion->update([
            'status' => $request->status,
            'admin_response' => $request->admin_response,
            'responded_at' => $request->status === 'responded' ? now() : $suggestion->responded_at,
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
            $suggestion->update(['status' => 'reviewed']);
        }

        return back()->with('success', 'تم وضع علامة مقروء');
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
                $suggestions->update(['status' => 'reviewed']);
                $message = 'تم وضع علامة مقروء على الاقتراحات المحددة';
                break;

            case 'mark_responded':
                $suggestions->update(['status' => 'responded', 'responded_at' => now()]);
                $message = 'تم وضع علامة مجاب على الاقتراحات المحددة';
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

<?php

namespace App\Http\Controllers;

use App\Models\Suggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index()
    {
        $suggestions = Auth::check()
            ? Auth::user()->suggestions()->orderBy('created_at', 'desc')->paginate(10)
            : collect();

        return view('user.suggestions', compact('suggestions'));
    }

    public function create()
    {
        return view('suggestions.create');
    }

    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $rules = [
            'message' => 'required|string|max:1000',
            'type' => 'required|in:suggestion,complaint,compliment',
            'is_anonymous' => 'nullable|boolean'
        ];

        // إذا لم يتم اختيار إرسال كمجهول، نطلب الاسم
        if (!$request->has('is_anonymous')) {
            $rules['name'] = 'required|string|max:100';
        }

        $messages = [
            'name.required' => 'الاسم مطلوب',
            'message.required' => 'الرسالة مطلوبة',
            'message.max' => 'الرسالة طويلة جداً',
            'type.required' => 'نوع الرسالة مطلوب',
            'type.in' => 'نوع الرسالة غير صحيح'
        ];

        $request->validate($rules, $messages);

        // إنشاء الاقتراح
        Suggestion::create([
            'user_id' => $request->has('is_anonymous') ? null : Auth::id(),
            'name' => $request->has('is_anonymous') ? 'مجهول' : $request->name,
            'suggestion' => $request->message, // تحويل اسم الحقل من message إلى suggestion
            'type' => $request->type,
            'status' => 'new',
            'anonymous' => $request->has('is_anonymous') ? true : false
        ]);

        return redirect()->route('suggestions.index')
            ->with('success', 'شكراً لك! تم إرسال رسالتك بنجاح وسنقوم بالرد عليك قريباً');
    }

    public function show(Suggestion $suggestion)
    {
        // التأكد من أن الاقتراح ينتمي للمستخدم الحالي
        if (Auth::check() && $suggestion->user_id === Auth::id()) {
            return view('suggestions.show', compact('suggestion'));
        }

        abort(403);
    }
}

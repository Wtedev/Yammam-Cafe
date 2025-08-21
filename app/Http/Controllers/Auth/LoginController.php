<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'mobile' => ['required', 'string', 'regex:/^[0-9+\-\s()]+$/'],
            'password' => ['required', 'string'],
        ], [
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.regex' => 'صيغة رقم الجوال غير صحيحة',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        // البحث عن المستخدم برقم الجوال
        $user = User::where('mobile', $request->mobile)->first();

        // التحقق من وجود المستخدم وصحة كلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'mobile' => ['رقم الجوال أو كلمة المرور غير صحيحة.'],
            ]);
        }

        // تسجيل دخول المستخدم
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // توجيه المستخدم حسب صلاحياته
        if ($user->isAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

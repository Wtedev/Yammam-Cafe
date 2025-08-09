<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[0-9+\-\s()]+$/', 'unique:users'],
            'office_number' => ['nullable', 'string', 'regex:/^[0-9+\-\s()]+$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'الاسم مطلوب',
            'name.max' => 'الاسم يجب أن يكون أقل من 255 حرف',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.regex' => 'صيغة رقم الجوال غير صحيحة',
            'mobile.unique' => 'رقم الجوال مستخدم من قبل',
            'office_number.regex' => 'صيغة رقم المكتب غير صحيحة',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
        ]);

        // إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'office_number' => $request->office_number,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // تسجيل دخول المستخدم تلقائياً
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'تم إنشاء الحساب بنجاح!');
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20', 'unique:users,mobile,' . $user->id],
        ], [
            'first_name.required' => 'الاسم الأول مطلوب',
            'first_name.max' => 'الاسم الأول يجب ألا يزيد عن 255 حرف',
            'last_name.required' => 'اسم العائلة مطلوب',
            'last_name.max' => 'اسم العائلة يجب ألا يزيد عن 255 حرف',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.unique' => 'رقم الجوال مستخدم من قبل مستخدم آخر',
            'mobile.max' => 'رقم الجوال يجب ألا يزيد عن 20 رقم',
        ]);

        $user->update([
            'name' => trim($request->first_name . ' ' . $request->last_name),
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('user.profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}

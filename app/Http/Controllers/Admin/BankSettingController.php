<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSetting;
use Illuminate\Http\Request;

class BankSettingController extends Controller
{
    /**
     * عرض صفحة إعدادات البنك
     */
    public function index()
    {
        $bankSettings = BankSetting::getSettings();
        return view('admin.bank-settings', compact('bankSettings'));
    }

    /**
     * تحديث إعدادات البنك
     */
    public function update(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_holder' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'iban' => 'required|string|max:50',
        ], [
            'bank_name.required' => 'اسم البنك مطلوب',
            'account_holder.required' => 'اسم صاحب الحساب مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'iban.required' => 'رقم الآيبان مطلوب',
        ]);

        BankSetting::updateSettings([
            'bank_name' => $request->bank_name,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
        ]);

        return back()->with('success', 'تم تحديث البيانات البنكية بنجاح');
    }
}

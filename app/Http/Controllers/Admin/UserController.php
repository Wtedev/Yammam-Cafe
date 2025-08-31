<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Models\BankSetting;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('mobile', 'like', '%' . $request->search . '%')
                    ->orWhere('office_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        $roleCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role');

        return view('admin.users.index', compact('users', 'roleCounts'));
    }

    public function show(User $user)
    {
        $user->load('orders', 'suggestions');
        return view('admin.users.show', compact('user'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:15|unique:users',
            'office_number' => 'nullable|string|max:10',
            'password' => 'required|string|min:6',
            'role' => 'required|in:user,admin'
        ], [
            'name.required' => 'الاسم مطلوب',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.unique' => 'رقم الجوال مسجل مسبقاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور قصيرة جداً',
            'role.required' => 'الدور مطلوب'
        ]);

        User::create([
            'name' => $request->name,
            'mobile' => $request->mobile,
            'office_number' => $request->office_number,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $user->id,
            'office_number' => 'nullable|string|max:10',
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:user,admin'
        ], [
            'name.required' => 'الاسم مطلوب',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.unique' => 'رقم الجوال مسجل مسبقاً',
            'password.min' => 'كلمة المرور قصيرة جداً',
            'role.required' => 'الدور مطلوب'
        ]);

        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'office_number' => $request->office_number,
            'role' => $request->role,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث المستخدم بنجاح');
    }

    public function destroy(User $user)
    {
        // التأكد من عدم حذف آخر مدير
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'لا يمكن حذف آخر مدير في النظام');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function toggleRole(Request $request, User $user)
    {
        $newRole = $user->role === 'user' ? 'admin' : 'user';
        $user->update(['role' => $newRole]);

        return back()->with('success', 'تم تغيير دور المستخدم بنجاح');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:15|unique:users,mobile,' . $user->id,
            'bank_name' => 'required|string|max:100',
            'account_holder' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'iban' => 'required|string|max:50',
        ], [
            'first_name.required' => 'الاسم الأول مطلوب',
            'last_name.required' => 'اسم العائلة مطلوب',
            'mobile.required' => 'رقم الجوال مطلوب',
            'mobile.unique' => 'رقم الجوال مسجل مسبقاً',
            'bank_name.required' => 'اسم البنك مطلوب',
            'account_holder.required' => 'اسم صاحب الحساب مطلوب',
            'account_number.required' => 'رقم الحساب مطلوب',
            'iban.required' => 'رقم الآيبان مطلوب',
        ]);

        // تحديث بيانات المستخدم
        $user->update([
            'name' => $request->first_name . ' ' . $request->last_name,
            'mobile' => $request->mobile,
        ]);

        // تحديث البيانات البنكية
        BankSetting::updateSettings([
            'bank_name' => $request->bank_name,
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'iban' => $request->iban,
        ]);

        return back()->with('success', 'تم تحديث البيانات الشخصية والبنكية بنجاح');
    }
}

<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            لوحة التحكم
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">مرحباً {{ Auth::user()->name }}</h3>
                    <p class="text-gray-600">تم تسجيل الدخول بنجاح!</p>

                    <div class="mt-6">
                        <p><strong>رقم الجوال:</strong> {{ Auth::user()->mobile }}</p>
                        @if(Auth::user()->office_number)
                        <p><strong>رقم المكتب:</strong> {{ Auth::user()->office_number }}</p>
                        @endif
                        <p><strong>الصلاحية:</strong> {{ Auth::user()->role }}</p>
                    </div>

                    <div class="mt-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>

<x-user-layout title="تواصل مع المطور">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6 text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">تواصل مع المطور</h1>
            <p class="text-gray-600">لمى المشيقح</p>
        </div>

        <!-- Contact Options -->
        <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl p-8 border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="https://wa.me/966590187528" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-xl bg-white hover:bg-green-50 transition-colors group border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <i class="fab fa-whatsapp text-2xl text-green-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-green-700">واتساب</h3>
                        <p class="text-sm text-gray-600">0590187528</p>
                    </div>
                </a>
                
                <a href="mailto:lamaalmushyqih@gmail.com" class="flex items-center gap-4 p-4 rounded-xl bg-white hover:bg-blue-50 transition-colors group border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-700">البريد الإلكتروني</h3>
                        <p class="text-sm text-gray-600">lamaalmushyqih@gmail.com</p>
                    </div>
                </a>
                
                <a href="https://www.linkedin.com/in/lama-almushyqih" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-xl bg-white hover:bg-blue-50 transition-colors group border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fab fa-linkedin text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-700">LinkedIn</h3>
                        <p class="text-sm text-gray-600">lama-almushyqih</p>
                    </div>
                </a>
                
                <a href="https://github.com/wtedev" target="_blank" rel="noopener" class="flex items-center gap-4 p-4 rounded-xl bg-white hover:bg-gray-50 transition-colors group border border-gray-100">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fab fa-github text-2xl text-gray-700"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-gray-800">GitHub</h3>
                        <p class="text-sm text-gray-600">wtedev</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-6">
            <a href="{{ route('user.profile') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors">
                <i class="fas fa-arrow-right"></i>
                <span>العودة للملف الشخصي</span>
            </a>
        </div>
    </div>
</x-user-layout>

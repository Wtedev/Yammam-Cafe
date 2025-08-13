<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Suggestion;
use App\Models\User;

class SuggestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $admin = User::where('role', 'admin')->first();

        $suggestions = [
            [
                'name' => 'أحمد محمد',
                'suggestion' => 'أقترح إضافة مشروبات صحية مثل العصائر الطبيعية والمشروبات الخضراء للموظفين المهتمين بالصحة.',
                'type' => 'suggestion',
                'status' => 'new',
                'user_id' => $users->random()->id,
                'anonymous' => false,
                'first_viewed_at' => null, // جديد
                'first_viewed_by' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
            [
                'name' => 'فاطمة عبدالله',
                'suggestion' => 'يمكن تحسين نظام الطلبات بإضافة إمكانية جدولة الطلبات مسبقاً للاجتماعات.',
                'type' => 'suggestion',
                'status' => 'new',
                'user_id' => $users->random()->id,
                'anonymous' => false,
                'first_viewed_at' => null, // جديد
                'first_viewed_by' => null,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'name' => 'خالد العلي',
                'suggestion' => 'إضافة خدمة توصيل مجانية للطلبات الكبيرة إلى المكاتب في الأدوار العليا.',
                'type' => 'suggestion',
                'status' => 'new',
                'user_id' => $users->random()->id,
                'anonymous' => false,
                'first_viewed_at' => null, // جديد
                'first_viewed_by' => null,
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12),
            ],
            [
                'name' => 'سارة أحمد',
                'suggestion' => 'القهوة في آخر طلبين كانت باردة عند الوصول. أرجو تحسين نظام الحفظ.',
                'type' => 'complaint',
                'status' => 'reviewing',
                'user_id' => $users->random()->id,
                'anonymous' => false,
                'first_viewed_at' => now()->subHours(6), // تمت مراجعته
                'first_viewed_by' => $admin->id,
                'admin_response' => 'شكراً لك على الملاحظة، سنعمل على تحسين نظام الحفظ.',
                'responded_at' => now()->subHours(4),
                'created_at' => now()->subHours(8),
                'updated_at' => now()->subHours(4),
            ],
            [
                'name' => null,
                'suggestion' => 'نحتاج المزيد من الخيارات النباتية في القائمة للموظفين النباتيين.',
                'type' => 'suggestion',
                'status' => 'implemented',
                'user_id' => $users->random()->id,
                'anonymous' => true,
                'first_viewed_at' => now()->subDays(5), // تمت مراجعته وحله
                'first_viewed_by' => $admin->id,
                'admin_response' => 'تم إضافة وجبات نباتية جديدة إلى القائمة.',
                'responded_at' => now()->subDays(3),
                'created_at' => now()->subWeek(),
                'updated_at' => now()->subDays(3),
            ],
        ];

        foreach ($suggestions as $suggestion) {
            Suggestion::create($suggestion);
        }
    }
}

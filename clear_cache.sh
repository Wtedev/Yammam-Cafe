#!/bin/bash

# مسح جميع أنواع الكاش في Laravel
echo "مسح كاش Laravel..."

# مسح كاش التطبيق
php artisan cache:clear

# مسح كاش الإعدادات
php artisan config:clear

# مسح كاش الراوتس
php artisan route:clear

# مسح كاش الفيوز
php artisan view:clear

# مسح كاش الأحداث
php artisan event:clear

# إعادة تحسين التطبيق
php artisan optimize

echo "تم مسح جميع أنواع الكاش بنجاح!"

# تعليمات Deployment لموقع يمام كافيه

## الأوامر المطلوبة على السيرفر بعد كل deployment:

### 1. مسح جميع أنواع الكاش:
```bash
php artisan cache:clear
php artisan config:clear  
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

### 2. إعادة بناء الكاش (اختياري للأداء):
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. صلاحيات الملفات:
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/ bootstrap/cache/
```

### 4. Storage Link (مرة واحدة فقط):
```bash
php artisan storage:link
```

### 5. في حالة مشاكل Database Cache:
```bash
php artisan migrate:refresh --force
php artisan db:seed --force
```

## مشاكل شائعة:

### المنتجات لا تختفي بعد الحذف:
- السبب: كاش Laravel أو كاش المتصفح
- الحل: تشغيل الأوامر أعلاه + مسح كاش المتصفح

### الصور لا تظهر:
- السبب: Storage link مفقود أو صلاحيات خاطئة
- الحل: `php artisan storage:link` + إعداد الصلاحيات

### تغييرات الإعدادات لا تظهر:
- السبب: Config cache
- الحل: `php artisan config:clear`

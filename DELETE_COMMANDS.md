# أوامر حذف المنتجات للـ deployment

## الأمر المباشر (نسخ ولصق في terminal السيرفر):

```bash
php artisan tinker --execute="
\$products = ['كيك شوكولاته', 'كروسان كوكولاته', 'تشيز كيك', 'ساندويتش جبن'];
foreach(\$products as \$productName) {
    \$deleted = App\Models\Product::where('name', 'LIKE', '%' . \$productName . '%')->delete();
    echo 'حذف منتجات تحتوي على: ' . \$productName . ' - عدد المحذوف: ' . \$deleted . PHP_EOL;
}
echo 'انتهى الحذف' . PHP_EOL;
" && php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

## أو أمر أبسط:

```bash
php artisan tinker --execute="App\Models\Product::where('name', 'LIKE', '%كيك%')->orWhere('name', 'LIKE', '%كروسان%')->orWhere('name', 'LIKE', '%تشيز%')->orWhere('name', 'LIKE', '%ساندويتش%')->delete(); echo 'تم حذف المنتجات';" && php artisan cache:clear
```

## للتحقق من الحذف:

```bash
php artisan tinker --execute="echo 'عدد المنتجات المتبقية: ' . App\Models\Product::count();"
```

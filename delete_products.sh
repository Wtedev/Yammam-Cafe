#!/bin/bash

echo "حذف المنتجات المحددة من قاعدة البيانات..."

php artisan tinker --execute="
\$products = ['كيك شوكولاته', 'كروسان كوكولاته', 'تشيز كيك', 'ساندويتش جبن'];
foreach(\$products as \$productName) {
    \$product = App\Models\Product::where('name', 'LIKE', '%' . \$productName . '%')->first();
    if(\$product) {
        echo 'حذف منتج: ' . \$product->name . PHP_EOL;
        \$product->delete();
    } else {
        echo 'لم يتم العثور على منتج: ' . \$productName . PHP_EOL;
    }
}
echo 'تم الانتهاء من حذف المنتجات' . PHP_EOL;
"

echo "مسح الكاش بعد الحذف..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "تم الانتهاء!"

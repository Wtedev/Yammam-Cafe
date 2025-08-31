<?php

use App\Models\Product;

// فحص المنتجات المذكورة
$products = Product::where('name', 'LIKE', '%كيك%')
    ->orWhere('name', 'LIKE', '%كروسان%')
    ->orWhere('name', 'LIKE', '%تشيز%')
    ->orWhere('name', 'LIKE', '%ساندويتش%')
    ->get(['id', 'name', 'is_available', 'deleted_at']);

echo "=== فحص المنتجات المذكورة ===\n";
foreach ($products as $product) {
    echo "ID: {$product->id} | الاسم: {$product->name} | متاح: " . ($product->is_available ? 'نعم' : 'لا') . "\n";
}

echo "\n=== جميع المنتجات المتاحة حالياً ===\n";
$availableProducts = Product::where('is_available', true)->get(['id', 'name']);
foreach ($availableProducts as $product) {
    echo "ID: {$product->id} | الاسم: {$product->name}\n";
}

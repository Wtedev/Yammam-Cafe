<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // يشير إلى المستخدم الذي قدم الطلب
            $table->string('office_number')->nullable(); // رقم المكتب (يتم سحبه من بيانات اليوزر)
            $table->enum('status', ['pending', 'processed', 'delivered', 'cancelled'])->default('pending'); // حالة الطلب
            $table->json('products'); // قائمة المنتجات (يتم تخزينها كـ JSON لإمكانية استلام أكثر من قيمة)
            $table->decimal('total_price', 10, 2); // السعر الإجمالي للطلب
            $table->timestamp('order_time'); // وقت الطلب
            $table->timestamp('delivery_time')->nullable(); // وقت التوصيل إذا كان متاحًا
            $table->enum('payment_method', ['network', 'bank_transfer', 'cash']); // طريقة الدفع
            $table->string('payment_image_url')->nullable(); // صورة التحويل إذا كان الدفع عن طريق التحويل البنكي
            $table->timestamp('first_viewed_at')->nullable(); // تاريخ أول مشاهدة للطلب من قبل الأدمن
            $table->foreignId('first_viewed_by')->nullable()->constrained('users')->nullOnDelete(); // الأدمن الذي شاهد الطلب أولاً
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuggestionsTable extends Migration
{
    public function up()
    {
        Schema::create('suggestions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // ربط المستخدم في حال كان مسجلاً
            $table->string('name')->nullable();
            $table->text('suggestion'); // نص الاقتراح
            $table->string('type')->default('suggestion'); // نوع الاقتراح: suggestion, complaint, compliment
            $table->string('status')->default('new'); // حالة الاقتراح: new, reviewing, approved, rejected, implemented
            $table->boolean('anonymous')->default(false); // خيار "لا ترسل اسمي" (يكون `true` إذا اختار المستخدم عدم إرسال اسمه)
            $table->text('admin_response')->nullable(); // رد المدير على الاقتراح
            $table->timestamp('responded_at')->nullable(); // وقت الرد على الاقتراح
            $table->timestamp('first_viewed_at')->nullable(); // تاريخ أول مشاهدة للاقتراح من قبل الأدمن
            $table->foreignId('first_viewed_by')->nullable()->constrained('users')->nullOnDelete(); // الأدمن الذي شاهد الاقتراح أولاً
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('suggestions');
    }
};

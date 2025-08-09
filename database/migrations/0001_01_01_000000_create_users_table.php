<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المستخدم
            $table->string('mobile')->unique(); // رقم الجوال، فريد
            $table->string('office_number')->nullable(); // رقم المكتب
            $table->string('password'); // كلمة المرور
            $table->enum('role', ['admin', 'user', 'guest'])->default('user'); // صلاحيات المستخدم
            $table->rememberToken(); // للمصادقة
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};

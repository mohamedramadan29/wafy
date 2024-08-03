<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->string('car_mark')->comment('الماركة')->nullable();
            $table->string('car_model')->nullable();
            $table->string('car_year')->comment('سنة الصنع')->nullable();
            $table->string('body_type')->comment('نوع الجسم ')->nullable();
            $table->string('door_number')->comment('عدد الابواب ')->nullable();
            $table->string('car_color')->nullable();
            $table->string('car_distance')->comment('المسافة المقطوعه ')->nullable();
            $table->string('solar_type')->comment('نوع الووقود')->nullable();
            $table->string('engine_capacity')->comment('سعة المحرك')->nullable();
            $table->string('car_transmission')->comment('ناقل الحركة ')->nullable();
            $table->string('car_accedant')->comment('تواريخ الحوادث')->nullable();
            $table->string('car_any_damage')->comment('وجود أي أضرار أو خدوش')->nullable();
            $table->string('tire_condition')->comment('حالة الإطارات')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_questions');
    }
};

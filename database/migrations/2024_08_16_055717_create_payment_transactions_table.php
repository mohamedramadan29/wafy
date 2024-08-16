<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('user_type');
            $table->integer('order_id');
            $table->string('price');
            $table->string('tap_id');
            $table->string('status');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};

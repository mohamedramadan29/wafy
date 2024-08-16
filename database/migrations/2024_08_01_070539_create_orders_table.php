<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('seller_id');
            $table->integer('buyer_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('price');
            $table->text('description');
            $table->text('images');
            $table->string('link');
            $table->integer('status')->default('0');
            $table->integer('inspection_center')->nullable();
            $table->integer('inspection_type')->nullable();
            $table->string('inspection_price')->nullable();
            $table->integer('seller_buy')->default('0');
            $table->integer('buyer_buy')->default('0');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

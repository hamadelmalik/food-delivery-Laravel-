<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // لو الجدول موجود مسبقًا، متعملش create
        if (!Schema::hasTable('cart_items')) {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity')->default(1);

                // عمود اختياري للـ spicy
                $table->decimal('spicy', 3, 2)->default(0);

                // عمود JSON لتخزين خيارات ديناميكية (toppings, side options, extras)
                $table->json('options')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};

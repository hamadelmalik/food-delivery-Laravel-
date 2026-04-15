<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id');
    $table->json('items');
    $table->decimal('taxes', 8, 2)->default(0);
    $table->decimal('delivery_fees', 8, 2)->default(0);
    $table->decimal('total', 8, 2);
    $table->string('payment_method')->nullable();
    $table->boolean('save_card')->default(false);
    $table->string('transaction_id')->nullable();
    $table->string('estimated_delivery_time')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};

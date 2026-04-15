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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');                 // اسم المنتج
        $table->text('description')->nullable(); // وصف المنتج
        $table->decimal('price', 8, 2);
        $table->decimal('rating', 3, 2)->nullable();        // سعر المنتج
        $table->unsignedBigInteger('category_id'); // الصنف
        $table->string('image')->nullable();    // صورة المنتج
        $table->timestamps();

        $table->foreign('category_id')
              ->references('id')
              ->on('categories')
              ->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

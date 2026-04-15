<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            // استبدل المسار القديم بالمسار الجديد
            if (str_contains($product->image, 'http://192.168.1.19:8000/storage/')) {
                $product->image = str_replace(
                    'http://192.168.1.19:8000/storage/',
                    'http://192.168.1.19:8000/storage/uploadimages/',
                    $product->image
                );
                $product->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            if (str_contains($product->image, 'http://192.168.1.19:8000/storage/uploadimages/')) {
                $product->image = str_replace(
                    'http://192.168.1.19:8000/storage/uploadimages/',
                    'http://192.168.1.19:8000/storage/',
                    $product->image
                );
                $product->save();
            }
        }
    }
};

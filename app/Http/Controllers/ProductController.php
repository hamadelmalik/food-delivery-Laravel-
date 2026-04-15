<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;




class ProductController extends Controller
{
    public function index()
{
    $products = Product::all(); // ← هنا تعريف المتغير

    return response()->json([
        'status' => true,
        'message' => 'تم جلب المنتجات بنجاح',
        'data' => ProductResource::collection($products),
    ]);
}


    public function create() {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'rating' => 'numeric',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $imageName = null;

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/uploadimages', $imageName);
    }

    Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'rating' => $request->rating,
        'category_id' => $request->category_id,
        'image' => $imageName, // ✅ اسم الصورة فقط
    ]);

    return redirect()->back()->with('success', 'Product added successfully');
}
    // دالة لتحديث روابط الصور القديمة
  public function fixImagePaths() {
    $products = Product::all();

    foreach ($products as $product) {

        if ($product->image) {

            // استخراج اسم الصورة فقط بدون أي مجلدات
            $filename = basename($product->image);

            // إعادة بناء المسار الصحيح
            $product->image = 'uploadimages/' . $filename;

            $product->save();
        }
    }

    return "All image paths fixed correctly!";
}
public function getSideOptions()
{
    $options = SideOption::all()->map(function ($item) {
        $item->image = asset('storage/' . $item->image);
        return $item;
    });

    return response()->json([
        'status' => true,
        'data' => $options
    ]);
}

public function getToppings()
{
    $toppings = Topping::all()->map(function ($item) {
        $item->image = asset('storage/' . $item->image);
        return $item;
    });

    return response()->json([
        'status' => true,
        'data' => $toppings
    ]);
}



}

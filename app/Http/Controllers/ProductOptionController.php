<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductOption;
use App\Models\OptionType;
use Illuminate\Support\Facades\DB;

class ProductOptionController extends Controller
{
    public function create()
{
    // لو محتاج تعرض أنواع الـ options في الفورم
    $types = OptionType::all();

    // رجع View فيه الفورم
    return view('product_options.create', compact('types'));
}

    // API: رجع كل الخيارات
    public function getOptions()
{
    $options = DB::table('product_options as po')
    ->leftJoin('option_types as ot', 'po.type_id', '=', 'ot.id')
    ->select(
        'po.id',
        'po.name',
        'po.type_id',
        'po.price',
        'po.image',
        'po.created_at',
        'po.updated_at',
        'ot.name as type_name'
    )
    ->orderBy('po.type_id')
    ->get();

    // نجمع حسب النوع
    $grouped = $options->groupBy('type_name');

    $data = [];
    foreach ($grouped as $typeName => $items) {
        $key = strtolower(str_replace(' ', '_', $typeName ?? 'type'));

        // نحذف type_name من كل عنصر
        $cleanItems = $items->map(function($item){
            unset($item->type_name);
            return $item;
        });

        $data[$key] = $cleanItems;
    }

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}
//new options

public function getOptionsnew()
{
    $result = DB::select("
        SELECT
            ot.name AS type_name,
            GROUP_CONCAT(po.name ORDER BY po.id SEPARATOR ', ') AS option_names
        FROM product_options po
        JOIN option_types ot ON po.type_id = ot.id
        GROUP BY po.type_id, ot.name
    ");

    $data = [];
    foreach ($result as $row) {
        $key = $row->type_name; // المفتاح مثل 'toppings' أو 'Side options'
        $data[$key][] = [
            'option_names' => $row->option_names
        ];
    }

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}
//end new option

    // API: إضافة خيارات جديدة
    public function store(Request $request)
    {
        $request->validate([
            'options.*.name' => 'required|string|max:255',
            'options.*.type_id' => 'required|exists:option_types,id',
            'options.*.price' => 'nullable|numeric',
            'options.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $created = [];
        foreach($request->options as $opt){
            $imageName = null;
            if(isset($opt['image'])){
                $imageName = time().'_'.$opt['image']->getClientOriginalName();
                $opt['image']->storeAs('public/uploadimages', $imageName);
            }

            $newOption = ProductOption::create([
                'name' => $opt['name'],
                'type_id' => $opt['type_id'],
                'price' => $opt['price'] ?? null,
                'image' => $imageName ? 'uploadimages/'.$imageName : null,
            ]);

            $created[] = $newOption;
        }

        return response()->json([
            'status' => true,
            'message' => 'Options added successfully',
            'data' => $created
        ]);
    }
}

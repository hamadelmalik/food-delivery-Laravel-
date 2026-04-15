<?php

namespace App\Http\Controllers;

use App\Models\OptionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionTypeController extends Controller
{
    public function index()
    {
        $types = OptionType::all();
        return view('option-types.index', compact('types'));
    }

    public function create()
    {
  $types = DB::table('product_options')
    ->select('id', 'name', 'type')
    ->get();
return view('option-types.create', compact('types'));

    }
    //new index

    public function indexnew()
{
    $types = \App\Models\OptionType::with('options')->get();

    $data = $types->map(function ($type) {
        return [
            'id' => $type->id,
            'name' => $type->name,
            'options' => $type->options->map(function ($opt) {
                return [
                    'id' => $opt->id,
                    'name' => $opt->name,
                    'price' => (float) $opt->price,
                    'image' => $opt->image,
                ];
            })->values()
        ];
    })->values();

    return response()->json([
        'status' => true,
        'data' => $data
    ]);
}
    //end index

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        OptionType::create(['name' => $request->name]);

        return redirect()->route('option-types.index')->with('success', 'Option Type added successfully');
    }

    public function edit(OptionType $optionType)
    {
        return view('option-types.edit', compact('optionType'));
    }

    public function update(Request $request, OptionType $optionType)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $optionType->update(['name' => $request->name]);

        return redirect()->route('option-types.index')->with('success', 'Option Type updated successfully');
    }

    public function destroy(OptionType $optionType)
    {
        $optionType->delete();
        return redirect()->route('option-types.index')->with('success', 'Option Type deleted');
    }
}

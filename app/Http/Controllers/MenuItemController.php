<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        return MenuItem::all();
    }

    public function store(Request $request)
    {
        return MenuItem::create($request->all());
    }

    public function show($id)
    {
        return MenuItem::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $item->update($request->all());
        return $item;
    }

    public function destroy($id)
    {
        MenuItem::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }
}

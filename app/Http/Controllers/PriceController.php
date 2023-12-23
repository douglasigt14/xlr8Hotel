<?php

namespace App\Http\Controllers;

use App\Models\Price;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index()
    {
        return Price::all();
    }

    public function store(Request $request)
    {
        return Price::create($request->all());
    }

    public function show($id)
    {
        $price = Price::find($id) ?? [];
        return $price;
    }

    public function update(Request $request, $id)
    {
        $price = Price::findOrFail($id);
        $price->update($request->all());
        return $price;
    }

    public function destroy($id)
    {
        $price = Price::findOrFail($id);
        $price->delete();
        return response()->json(['message' => 'Price deleted successfully']);
    }
}

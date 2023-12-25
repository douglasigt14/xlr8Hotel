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
        Price::create($request->all());
        return response()->json(['msg' => 'Criado com sucesso']);
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
        return response()->json(['msg' => 'Preço editado']);
    }

    public function destroy($id)
    {
        $price = Price::findOrFail($id);
        $price->delete();
        return response()->json(['msg' => 'Preço deletado']);
    }
}

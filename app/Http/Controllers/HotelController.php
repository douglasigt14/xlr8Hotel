<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return Hotel::select("name","location", "image_url")->get();
    }

    public function store(Request $request)
    {
        Hotel::create($request->all());
        return response()->json(['msg' => 'Hotel criado com sucesso']);
    }

    public function show($id)
    {
        $hotel = Hotel::find($id) ?? [];
        return $hotel;
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
        return $hotel;
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['msg' => 'Hotel deletado']);
    }
}
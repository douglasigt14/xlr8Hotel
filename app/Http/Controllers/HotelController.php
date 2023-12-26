<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Price;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return Hotel::select("id","name","location", "image_url")->get();
    }

    public function store(Request $request)
    {
            $request->validate([
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);

            $hotel = new Hotel;
            $hotel->name = $request->input('name');
            $hotel->location = $request->input('location');
            $hotel->image_url = 'images/' . $imageName;

            return response()->json(['msg' => 'Criado com sucesso']);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        if ($request->hasFile('image_url')) {
            $request->validate([
                'image_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $hotel->image_url = 'images/' . $imageName;
        }

        $hotel->name = $request->input('name', $hotel->name);
        $hotel->location = $request->input('location', $hotel->location);
        $hotel->save();

        return response()->json(['msg' => $hotel->name.' editado']);
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['msg' => $hotel->name.' deletado']);
    }

    public function detailsAll()
    {
        $hotels = Hotel::select("id", "name", "location", "image_url")->get();

        
        foreach ($hotels as $hotel) {
            $rooms = Room::select("id", "room_type", "number_of_rooms")->where('hotel_id', $hotel->id)->get();
            foreach ($rooms as $room) {
                $room->prices =  Price::select("id", "stay_date","price")->where('room_id', $room->id)->get();
            }
            $hotel->rooms  = $rooms->toArray();
        }

        return $hotels->toArray();
    }

    public function detailsForId($hotalId)
    {
        $hotels = Hotel::select("id", "name", "location", "image_url")->where('id',$hotalId)->get();

        
        foreach ($hotels as $hotel) {
            $rooms = Room::select("id", "room_type", "number_of_rooms")->where('hotel_id', $hotel->id)->get();
            foreach ($rooms as $room) {
                $room->prices =  Price::select("id", "stay_date","price")->where('room_id', $room->id)->get();
            }
            $hotel->rooms  = $rooms->toArray();
        }

        return $hotels->toArray();
    }
}
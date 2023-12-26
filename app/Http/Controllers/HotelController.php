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
        Hotel::create($request->all());
        return response()->json(['msg' => 'Criado com sucesso']);
    }

    public function update(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->update($request->all());
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
                $room->prices =  Price::select("id", "room_id", "stay_date","price")->where('room_id', $room->id)->get();
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
                $room->prices =  Price::select("id", "room_id", "stay_date","price")->where('room_id', $room->id)->get();
            }
            $hotel->rooms  = $rooms->toArray();
        }

        return $hotels->toArray();
    }
}